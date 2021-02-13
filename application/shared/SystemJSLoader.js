const SystemJSConf = {
    baseFolderPath : './public/dist/pages/'
}

/**
 * @Class 
 * Import javascript on demand
 */
class SystemJSImports{
    constructor({baseFolderPath}){
        this.baseFolderPath = baseFolderPath;
        this.path = this.getPath();
        this.importMainPageModule();
    }

    getPath = function(){
        let URI = location.pathname.substring(1);
        let splitURI = URI.split('/');
        let route =  splitURI[splitURI.length - 1];
        let path = `${this.baseFolderPath}${route}/${route.charAt(0).toUpperCase() + route.slice(1)}.js`;
        return path;
    }

    importMainPageModule = function(){
        System.import(this.path);
    }

}

/**
 * Instances of objects in the general scop 
 */
const systemJSImports = new SystemJSImports(SystemJSConf);