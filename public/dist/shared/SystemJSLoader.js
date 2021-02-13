"use strict";
var SystemJSConf = {
    baseFolderPath: './public/dist/pages/'
};
var SystemJSImports = (function () {
    function SystemJSImports(_a) {
        var baseFolderPath = _a.baseFolderPath;
        this.getPath = function () {
            var URI = location.pathname.substring(1);
            var splitURI = URI.split('/');
            var route = splitURI[splitURI.length - 1];
            var path = "" + this.baseFolderPath + route + "/" + (route.charAt(0).toUpperCase() + route.slice(1)) + ".js";
            return path;
        };
        this.importMainPageModule = function () {
            System.import(this.path);
        };
        this.baseFolderPath = baseFolderPath;
        this.path = this.getPath();
        this.importMainPageModule();
    }
    return SystemJSImports;
}());
var systemJSImports = new SystemJSImports(SystemJSConf);
