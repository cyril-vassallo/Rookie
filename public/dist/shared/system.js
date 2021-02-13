"use strict";
(function () {
    function errMsg(errCode, msg) {
        return (msg || "") + " (SystemJS Error#" + errCode + " " + "https://git.io/JvFET#" + errCode + ")";
    }
    var hasSymbol = typeof Symbol !== 'undefined';
    var hasSelf = typeof self !== 'undefined';
    var hasDocument = typeof document !== 'undefined';
    var envGlobal = hasSelf ? self : global;
    var baseUrl;
    if (hasDocument) {
        var baseEl = document.querySelector('base[href]');
        if (baseEl)
            baseUrl = baseEl.href;
    }
    if (!baseUrl && typeof location !== 'undefined') {
        baseUrl = location.href.split('#')[0].split('?')[0];
        var lastSepIndex = baseUrl.lastIndexOf('/');
        if (lastSepIndex !== -1)
            baseUrl = baseUrl.slice(0, lastSepIndex + 1);
    }
    var backslashRegEx = /\\/g;
    function resolveIfNotPlainOrUrl(relUrl, parentUrl) {
        if (relUrl.indexOf('\\') !== -1)
            relUrl = relUrl.replace(backslashRegEx, '/');
        if (relUrl[0] === '/' && relUrl[1] === '/') {
            return parentUrl.slice(0, parentUrl.indexOf(':') + 1) + relUrl;
        }
        else if (relUrl[0] === '.' && (relUrl[1] === '/' || relUrl[1] === '.' && (relUrl[2] === '/' || relUrl.length === 2 && (relUrl += '/')) ||
            relUrl.length === 1 && (relUrl += '/')) ||
            relUrl[0] === '/') {
            var parentProtocol = parentUrl.slice(0, parentUrl.indexOf(':') + 1);
            var pathname;
            if (parentUrl[parentProtocol.length + 1] === '/') {
                if (parentProtocol !== 'file:') {
                    pathname = parentUrl.slice(parentProtocol.length + 2);
                    pathname = pathname.slice(pathname.indexOf('/') + 1);
                }
                else {
                    pathname = parentUrl.slice(8);
                }
            }
            else {
                pathname = parentUrl.slice(parentProtocol.length + (parentUrl[parentProtocol.length] === '/'));
            }
            if (relUrl[0] === '/')
                return parentUrl.slice(0, parentUrl.length - pathname.length - 1) + relUrl;
            var segmented = pathname.slice(0, pathname.lastIndexOf('/') + 1) + relUrl;
            var output = [];
            var segmentIndex = -1;
            for (var i = 0; i < segmented.length; i++) {
                if (segmentIndex !== -1) {
                    if (segmented[i] === '/') {
                        output.push(segmented.slice(segmentIndex, i + 1));
                        segmentIndex = -1;
                    }
                }
                else if (segmented[i] === '.') {
                    if (segmented[i + 1] === '.' && (segmented[i + 2] === '/' || i + 2 === segmented.length)) {
                        output.pop();
                        i += 2;
                    }
                    else if (segmented[i + 1] === '/' || i + 1 === segmented.length) {
                        i += 1;
                    }
                    else {
                        segmentIndex = i;
                    }
                }
                else {
                    segmentIndex = i;
                }
            }
            if (segmentIndex !== -1)
                output.push(segmented.slice(segmentIndex));
            return parentUrl.slice(0, parentUrl.length - pathname.length) + output.join('');
        }
    }
    function resolveUrl(relUrl, parentUrl) {
        return resolveIfNotPlainOrUrl(relUrl, parentUrl) || (relUrl.indexOf(':') !== -1 ? relUrl : resolveIfNotPlainOrUrl('./' + relUrl, parentUrl));
    }
    function resolveAndComposePackages(packages, outPackages, baseUrl, parentMap, parentUrl) {
        for (var p in packages) {
            var resolvedLhs = resolveIfNotPlainOrUrl(p, baseUrl) || p;
            var rhs = packages[p];
            if (typeof rhs !== 'string')
                continue;
            var mapped = resolveImportMap(parentMap, resolveIfNotPlainOrUrl(rhs, baseUrl) || rhs, parentUrl);
            if (!mapped) {
                targetWarning('W1', p, rhs, 'bare specifier did not resolve');
            }
            else
                outPackages[resolvedLhs] = mapped;
        }
    }
    function resolveAndComposeImportMap(json, baseUrl, outMap) {
        if (json.imports)
            resolveAndComposePackages(json.imports, outMap.imports, baseUrl, outMap, null);
        var u;
        for (u in json.scopes || {}) {
            var resolvedScope = resolveUrl(u, baseUrl);
            resolveAndComposePackages(json.scopes[u], outMap.scopes[resolvedScope] || (outMap.scopes[resolvedScope] = {}), baseUrl, outMap, resolvedScope);
        }
        for (u in json.depcache || {})
            outMap.depcache[resolveUrl(u, baseUrl)] = json.depcache[u];
        for (u in json.integrity || {})
            outMap.integrity[resolveUrl(u, baseUrl)] = json.integrity[u];
    }
    function getMatch(path, matchObj) {
        if (matchObj[path])
            return path;
        var sepIndex = path.length;
        do {
            var segment = path.slice(0, sepIndex + 1);
            if (segment in matchObj)
                return segment;
        } while ((sepIndex = path.lastIndexOf('/', sepIndex - 1)) !== -1);
    }
    function applyPackages(id, packages) {
        var pkgName = getMatch(id, packages);
        if (pkgName) {
            var pkg = packages[pkgName];
            if (pkg === null)
                return;
            if (id.length > pkgName.length && pkg[pkg.length - 1] !== '/') {
                targetWarning('W2', pkgName, pkg, "should have a trailing '/'");
            }
            else
                return pkg + id.slice(pkgName.length);
        }
    }
    function targetWarning(code, match, target, msg) {
        console.warn(errMsg(code, "Package target " + msg + ", resolving target '" + target + "' for " + match));
    }
    function resolveImportMap(importMap, resolvedOrPlain, parentUrl) {
        var scopes = importMap.scopes;
        var scopeUrl = parentUrl && getMatch(parentUrl, scopes);
        while (scopeUrl) {
            var packageResolution = applyPackages(resolvedOrPlain, scopes[scopeUrl]);
            if (packageResolution)
                return packageResolution;
            scopeUrl = getMatch(scopeUrl.slice(0, scopeUrl.lastIndexOf('/')), scopes);
        }
        return applyPackages(resolvedOrPlain, importMap.imports) || resolvedOrPlain.indexOf(':') !== -1 && resolvedOrPlain;
    }
    var toStringTag = hasSymbol && Symbol.toStringTag;
    var REGISTRY = hasSymbol ? Symbol() : '@';
    function SystemJS() {
        this[REGISTRY] = {};
    }
    var systemJSPrototype = SystemJS.prototype;
    systemJSPrototype.import = function (id, parentUrl) {
        var loader = this;
        return Promise.resolve(loader.prepareImport())
            .then(function () {
            return loader.resolve(id, parentUrl);
        })
            .then(function (id) {
            var load = getOrCreateLoad(loader, id);
            return load.C || topLevelLoad(loader, load);
        });
    };
    systemJSPrototype.createContext = function (parentId) {
        var loader = this;
        return {
            url: parentId,
            resolve: function (id, parentUrl) {
                return Promise.resolve(loader.resolve(id, parentUrl || parentId));
            }
        };
    };
    systemJSPrototype.onload = function () { };
    function loadToId(load) {
        return load.id;
    }
    function triggerOnload(loader, load, err, isErrSource) {
        loader.onload(err, load.id, load.d && load.d.map(loadToId), !!isErrSource);
        if (err)
            throw err;
    }
    var lastRegister;
    systemJSPrototype.register = function (deps, declare) {
        lastRegister = [deps, declare];
    };
    systemJSPrototype.getRegister = function () {
        var _lastRegister = lastRegister;
        lastRegister = undefined;
        return _lastRegister;
    };
    function getOrCreateLoad(loader, id, firstParentUrl) {
        var load = loader[REGISTRY][id];
        if (load)
            return load;
        var importerSetters = [];
        var ns = Object.create(null);
        if (toStringTag)
            Object.defineProperty(ns, toStringTag, { value: 'Module' });
        var instantiatePromise = Promise.resolve()
            .then(function () {
            return loader.instantiate(id, firstParentUrl);
        })
            .then(function (registration) {
            if (!registration)
                throw Error(errMsg(2, 'Module ' + id + ' did not instantiate'));
            function _export(name, value) {
                load.h = true;
                var changed = false;
                if (typeof name === 'string') {
                    if (!(name in ns) || ns[name] !== value) {
                        ns[name] = value;
                        changed = true;
                    }
                }
                else {
                    for (var p in name) {
                        var value = name[p];
                        if (!(p in ns) || ns[p] !== value) {
                            ns[p] = value;
                            changed = true;
                        }
                    }
                    if (name.__esModule) {
                        ns.__esModule = name.__esModule;
                    }
                }
                if (changed)
                    for (var i = 0; i < importerSetters.length; i++) {
                        var setter = importerSetters[i];
                        if (setter)
                            setter(ns);
                    }
                return value;
            }
            var declared = registration[1](_export, registration[1].length === 2 ? {
                import: function (importId) {
                    return loader.import(importId, id);
                },
                meta: loader.createContext(id)
            } : undefined);
            load.e = declared.execute || function () { };
            return [registration[0], declared.setters || []];
        }, function (err) {
            load.e = null;
            load.er = err;
            triggerOnload(loader, load, err, true);
            throw err;
        });
        var linkPromise = instantiatePromise
            .then(function (instantiation) {
            return Promise.all(instantiation[0].map(function (dep, i) {
                var setter = instantiation[1][i];
                return Promise.resolve(loader.resolve(dep, id))
                    .then(function (depId) {
                    var depLoad = getOrCreateLoad(loader, depId, id);
                    return Promise.resolve(depLoad.I)
                        .then(function () {
                        if (setter) {
                            depLoad.i.push(setter);
                            if (depLoad.h || !depLoad.I)
                                setter(depLoad.n);
                        }
                        return depLoad;
                    });
                });
            }))
                .then(function (depLoads) {
                load.d = depLoads;
            });
        });
        return load = loader[REGISTRY][id] = {
            id: id,
            i: importerSetters,
            n: ns,
            I: instantiatePromise,
            L: linkPromise,
            h: false,
            d: undefined,
            e: undefined,
            er: undefined,
            E: undefined,
            C: undefined,
            p: undefined
        };
    }
    function instantiateAll(loader, load, parent, loaded) {
        if (!loaded[load.id]) {
            loaded[load.id] = true;
            return Promise.resolve(load.L)
                .then(function () {
                if (!load.p || load.p.e === null)
                    load.p = parent;
                return Promise.all(load.d.map(function (dep) {
                    return instantiateAll(loader, dep, parent, loaded);
                }));
            })
                .catch(function (err) {
                if (load.er)
                    throw err;
                load.e = null;
                triggerOnload(loader, load, err, false);
                throw err;
            });
        }
    }
    function topLevelLoad(loader, load) {
        return load.C = instantiateAll(loader, load, load, {})
            .then(function () {
            return postOrderExec(loader, load, {});
        })
            .then(function () {
            return load.n;
        });
    }
    var nullContext = Object.freeze(Object.create(null));
    function postOrderExec(loader, load, seen) {
        if (seen[load.id])
            return;
        seen[load.id] = true;
        if (!load.e) {
            if (load.er)
                throw load.er;
            if (load.E)
                return load.E;
            return;
        }
        var depLoadPromises;
        load.d.forEach(function (depLoad) {
            try {
                var depLoadPromise = postOrderExec(loader, depLoad, seen);
                if (depLoadPromise)
                    (depLoadPromises = depLoadPromises || []).push(depLoadPromise);
            }
            catch (err) {
                load.e = null;
                load.er = err;
                triggerOnload(loader, load, err, false);
                throw err;
            }
        });
        if (depLoadPromises)
            return Promise.all(depLoadPromises).then(doExec);
        return doExec();
        function doExec() {
            try {
                var execPromise = load.e.call(nullContext);
                if (execPromise) {
                    execPromise = execPromise.then(function () {
                        load.C = load.n;
                        load.E = null;
                        if (!false)
                            triggerOnload(loader, load, null, true);
                    }, function (err) {
                        load.er = err;
                        load.E = null;
                        if (!false)
                            triggerOnload(loader, load, err, true);
                        throw err;
                    });
                    return load.E = execPromise;
                }
                load.C = load.n;
                load.L = load.I = undefined;
            }
            catch (err) {
                load.er = err;
                throw err;
            }
            finally {
                load.e = null;
                triggerOnload(loader, load, load.er, true);
            }
        }
    }
    envGlobal.System = new SystemJS();
    var importMapPromise = Promise.resolve();
    var importMap = { imports: {}, scopes: {}, depcache: {}, integrity: {} };
    var processFirst = hasDocument;
    systemJSPrototype.prepareImport = function (doProcessScripts) {
        if (processFirst || doProcessScripts) {
            processScripts();
            processFirst = false;
        }
        return importMapPromise;
    };
    if (hasDocument) {
        processScripts();
        window.addEventListener('DOMContentLoaded', processScripts);
    }
    function processScripts() {
        [].forEach.call(document.querySelectorAll('script'), function (script) {
            if (script.sp)
                return;
            if (script.type === 'systemjs-module') {
                script.sp = true;
                if (!script.src)
                    return;
                System.import(script.src.slice(0, 7) === 'import:' ? script.src.slice(7) : resolveUrl(script.src, baseUrl)).catch(function (e) {
                    if (e.message.indexOf('https://git.io/JvFET#3') > -1) {
                        var event = document.createEvent('Event');
                        event.initEvent('error', false, false);
                        script.dispatchEvent(event);
                    }
                    return Promise.reject(e);
                });
            }
            else if (script.type === 'systemjs-importmap') {
                script.sp = true;
                var fetchPromise = script.src ? fetch(script.src, { integrity: script.integrity }).then(function (res) {
                    if (!res.ok)
                        throw Error('Invalid status code: ' + res.status);
                    return res.text();
                }).catch(function (err) {
                    err.message = errMsg('W4', 'Error fetching systemjs-import map ' + script.src) + '\n' + err.message;
                    console.warn(err);
                    return '{}';
                }) : script.innerHTML;
                importMapPromise = importMapPromise.then(function () {
                    return fetchPromise;
                }).then(function (text) {
                    extendImportMap(importMap, text, script.src || baseUrl);
                });
            }
        });
    }
    function extendImportMap(importMap, newMapText, newMapUrl) {
        var newMap = {};
        try {
            newMap = JSON.parse(newMapText);
        }
        catch (err) {
            console.warn(Error((errMsg('W5', "systemjs-importmap contains invalid JSON") + '\n\n' + newMapText + '\n')));
        }
        resolveAndComposeImportMap(newMap, newMapUrl, importMap);
    }
    if (hasDocument) {
        window.addEventListener('error', function (evt) {
            lastWindowErrorUrl = evt.filename;
            lastWindowError = evt.error;
        });
        var baseOrigin = location.origin;
    }
    systemJSPrototype.createScript = function (url) {
        var script = document.createElement('script');
        script.async = true;
        if (url.indexOf(baseOrigin + '/'))
            script.crossOrigin = 'anonymous';
        var integrity = importMap.integrity[url];
        if (integrity)
            script.integrity = integrity;
        script.src = url;
        return script;
    };
    var lastAutoImportUrl, lastAutoImportDeps, lastAutoImportTimeout;
    var autoImportCandidates = {};
    var systemRegister = systemJSPrototype.register;
    systemJSPrototype.register = function (deps, declare) {
        if (hasDocument && document.readyState === 'loading' && typeof deps !== 'string') {
            var scripts = document.querySelectorAll('script[src]');
            var lastScript = scripts[scripts.length - 1];
            if (lastScript) {
                lastAutoImportUrl = lastScript.src;
                lastAutoImportDeps = deps;
                var loader = this;
                lastAutoImportTimeout = setTimeout(function () {
                    autoImportCandidates[lastScript.src] = [deps, declare];
                    loader.import(lastScript.src);
                });
            }
        }
        else {
            lastAutoImportDeps = undefined;
        }
        return systemRegister.call(this, deps, declare);
    };
    var lastWindowErrorUrl, lastWindowError;
    systemJSPrototype.instantiate = function (url, firstParentUrl) {
        var autoImportRegistration = autoImportCandidates[url];
        if (autoImportRegistration) {
            delete autoImportCandidates[url];
            return autoImportRegistration;
        }
        var loader = this;
        return new Promise(function (resolve, reject) {
            var script = systemJSPrototype.createScript(url);
            script.addEventListener('error', function () {
                reject(Error(errMsg(3, 'Error loading ' + url + (firstParentUrl ? ' from ' + firstParentUrl : ''))));
            });
            script.addEventListener('load', function () {
                document.head.removeChild(script);
                if (lastWindowErrorUrl === url) {
                    reject(lastWindowError);
                }
                else {
                    var register = loader.getRegister();
                    if (register && register[0] === lastAutoImportDeps)
                        clearTimeout(lastAutoImportTimeout);
                    resolve(register);
                }
            });
            document.head.appendChild(script);
        });
    };
    systemJSPrototype.shouldFetch = function () {
        return false;
    };
    if (typeof fetch !== 'undefined')
        systemJSPrototype.fetch = fetch;
    var instantiate = systemJSPrototype.instantiate;
    var jsContentTypeRegEx = /^(text|application)\/(x-)?javascript(;|$)/;
    systemJSPrototype.instantiate = function (url, parent) {
        var loader = this;
        if (!this.shouldFetch(url))
            return instantiate.apply(this, arguments);
        return this.fetch(url, {
            credentials: 'same-origin',
            integrity: importMap.integrity[url]
        })
            .then(function (res) {
            if (!res.ok)
                throw Error(errMsg(7, res.status + ' ' + res.statusText + ', loading ' + url + (parent ? ' from ' + parent : '')));
            var contentType = res.headers.get('content-type');
            if (!contentType || !jsContentTypeRegEx.test(contentType))
                throw Error(errMsg(4, 'Unknown Content-Type "' + contentType + '", loading ' + url + (parent ? ' from ' + parent : '')));
            return res.text().then(function (source) {
                if (source.indexOf('//# sourceURL=') < 0)
                    source += '\n//# sourceURL=' + url;
                (0, eval)(source);
                return loader.getRegister();
            });
        });
    };
    systemJSPrototype.resolve = function (id, parentUrl) {
        parentUrl = parentUrl || !true || baseUrl;
        return resolveImportMap((importMap), resolveIfNotPlainOrUrl(id, parentUrl) || id, parentUrl) || throwUnresolved(id, parentUrl);
    };
    function throwUnresolved(id, parentUrl) {
        throw Error(errMsg(8, "Unable to resolve bare specifier '" + id + (parentUrl ? "' from " + parentUrl : "'")));
    }
    var systemInstantiate = systemJSPrototype.instantiate;
    systemJSPrototype.instantiate = function (url, firstParentUrl) {
        var preloads = (importMap).depcache[url];
        if (preloads) {
            for (var i = 0; i < preloads.length; i++)
                getOrCreateLoad(this, this.resolve(preloads[i], url), url);
        }
        return systemInstantiate.call(this, url, firstParentUrl);
    };
    if (hasSelf && typeof importScripts === 'function')
        systemJSPrototype.instantiate = function (url) {
            var loader = this;
            return Promise.resolve().then(function () {
                importScripts(url);
                return loader.getRegister();
            });
        };
    (function (global) {
        var systemJSPrototype = global.System.constructor.prototype;
        var firstGlobalProp, secondGlobalProp, lastGlobalProp;
        function getGlobalProp(useFirstGlobalProp) {
            var cnt = 0;
            var foundLastProp, result;
            for (var p in global) {
                if (shouldSkipProperty(p))
                    continue;
                if (cnt === 0 && p !== firstGlobalProp || cnt === 1 && p !== secondGlobalProp)
                    return p;
                if (foundLastProp) {
                    lastGlobalProp = p;
                    result = useFirstGlobalProp && result || p;
                }
                else {
                    foundLastProp = p === lastGlobalProp;
                }
                cnt++;
            }
            return result;
        }
        function noteGlobalProps() {
            firstGlobalProp = secondGlobalProp = undefined;
            for (var p in global) {
                if (shouldSkipProperty(p))
                    continue;
                if (!firstGlobalProp)
                    firstGlobalProp = p;
                else if (!secondGlobalProp)
                    secondGlobalProp = p;
                lastGlobalProp = p;
            }
            return lastGlobalProp;
        }
        var impt = systemJSPrototype.import;
        systemJSPrototype.import = function (id, parentUrl) {
            noteGlobalProps();
            return impt.call(this, id, parentUrl);
        };
        var emptyInstantiation = [[], function () { return {}; }];
        var getRegister = systemJSPrototype.getRegister;
        systemJSPrototype.getRegister = function () {
            var lastRegister = getRegister.call(this);
            if (lastRegister)
                return lastRegister;
            var globalProp = getGlobalProp(this.firstGlobalProp);
            if (!globalProp)
                return emptyInstantiation;
            var globalExport;
            try {
                globalExport = global[globalProp];
            }
            catch (e) {
                return emptyInstantiation;
            }
            return [[], function (_export) {
                    return {
                        execute: function () {
                            _export(globalExport);
                            _export({ default: globalExport, __useDefault: true });
                        }
                    };
                }];
        };
        var isIE11 = typeof navigator !== 'undefined' && navigator.userAgent.indexOf('Trident') !== -1;
        function shouldSkipProperty(p) {
            return !global.hasOwnProperty(p)
                || !isNaN(p) && p < global.length
                || isIE11 && global[p] && typeof window !== 'undefined' && global[p].parent === window;
        }
    })(typeof self !== 'undefined' ? self : global);
    (function (global) {
        var systemJSPrototype = global.System.constructor.prototype;
        var moduleTypesRegEx = /^[^#?]+\.(css|html|json|wasm)([?#].*)?$/;
        systemJSPrototype.shouldFetch = function (url) {
            return moduleTypesRegEx.test(url);
        };
        var jsonContentType = /^application\/json(;|$)/;
        var cssContentType = /^text\/css(;|$)/;
        var wasmContentType = /^application\/wasm(;|$)/;
        var fetch = systemJSPrototype.fetch;
        systemJSPrototype.fetch = function (url, options) {
            return fetch(url, options)
                .then(function (res) {
                if (!res.ok)
                    return res;
                var contentType = res.headers.get('content-type');
                if (jsonContentType.test(contentType))
                    return res.json()
                        .then(function (json) {
                        return new Response(new Blob([
                            'System.register([],function(e){return{execute:function(){e("default",' + JSON.stringify(json) + ')}}})'
                        ], {
                            type: 'application/javascript'
                        }));
                    });
                if (cssContentType.test(contentType))
                    return res.text()
                        .then(function (source) {
                        return new Response(new Blob([
                            'System.register([],function(e){return{execute:function(){var s=new CSSStyleSheet();s.replaceSync(' + JSON.stringify(source) + ');e("default",s)}}})'
                        ], {
                            type: 'application/javascript'
                        }));
                    });
                if (wasmContentType.test(contentType))
                    return (WebAssembly.compileStreaming ? WebAssembly.compileStreaming(res) : res.arrayBuffer().then(WebAssembly.compile))
                        .then(function (module) {
                        if (!global.System.wasmModules)
                            global.System.wasmModules = Object.create(null);
                        global.System.wasmModules[url] = module;
                        var deps = [];
                        var setterSources = [];
                        if (WebAssembly.Module.imports)
                            WebAssembly.Module.imports(module).forEach(function (impt) {
                                var key = JSON.stringify(impt.module);
                                if (deps.indexOf(key) === -1) {
                                    deps.push(key);
                                    setterSources.push('function(m){i[' + key + ']=m}');
                                }
                            });
                        return new Response(new Blob([
                            'System.register([' + deps.join(',') + '],function(e){var i={};return{setters:[' + setterSources.join(',') +
                                '],execute:function(){return WebAssembly.instantiate(System.wasmModules[' + JSON.stringify(url) +
                                '],i).then(function(m){e(m.exports)})}}})'
                        ], {
                            type: 'application/javascript'
                        }));
                    });
                return res;
            });
        };
    })(typeof self !== 'undefined' ? self : global);
    var toStringTag$1 = typeof Symbol !== 'undefined' && Symbol.toStringTag;
    systemJSPrototype.get = function (id) {
        var load = this[REGISTRY][id];
        if (load && load.e === null && !load.E) {
            if (load.er)
                return null;
            return load.n;
        }
    };
    systemJSPrototype.set = function (id, module) {
        {
            try {
                new URL(id);
            }
            catch (err) {
                console.warn(Error(errMsg('W3', '"' + id + '" is not a valid URL to set in the module registry')));
            }
        }
        var ns;
        if (toStringTag$1 && module[toStringTag$1] === 'Module') {
            ns = module;
        }
        else {
            ns = Object.assign(Object.create(null), module);
            if (toStringTag$1)
                Object.defineProperty(ns, toStringTag$1, { value: 'Module' });
        }
        var done = Promise.resolve(ns);
        var load = this[REGISTRY][id] || (this[REGISTRY][id] = {
            id: id,
            i: [],
            h: false,
            d: [],
            e: null,
            er: undefined,
            E: undefined
        });
        if (load.e || load.E)
            return false;
        Object.assign(load, {
            n: ns,
            I: undefined,
            L: undefined,
            C: done
        });
        return ns;
    };
    systemJSPrototype.has = function (id) {
        var load = this[REGISTRY][id];
        return !!load;
    };
    systemJSPrototype.delete = function (id) {
        var registry = this[REGISTRY];
        var load = registry[id];
        if (!load || (load.p && load.p.e !== null) || load.E)
            return false;
        var importerSetters = load.i;
        if (load.d)
            load.d.forEach(function (depLoad) {
                var importerIndex = depLoad.i.indexOf(load);
                if (importerIndex !== -1)
                    depLoad.i.splice(importerIndex, 1);
            });
        delete registry[id];
        return function () {
            var load = registry[id];
            if (!load || !importerSetters || load.e !== null || load.E)
                return false;
            importerSetters.forEach(function (setter) {
                load.i.push(setter);
                setter(load.n);
            });
            importerSetters = null;
        };
    };
    var iterator = typeof Symbol !== 'undefined' && Symbol.iterator;
    systemJSPrototype.entries = function () {
        var loader = this, keys = Object.keys(loader[REGISTRY]);
        var index = 0, ns, key;
        var result = {
            next: function () {
                while ((key = keys[index++]) !== undefined &&
                    (ns = loader.get(key)) === undefined)
                    ;
                return {
                    done: key === undefined,
                    value: key !== undefined && [key, ns]
                };
            }
        };
        result[iterator] = function () { return this; };
        return result;
    };
}());
