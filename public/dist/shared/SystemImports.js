"use strict";
var SystemImports = (function () {
    function SystemImports(_a) {
        var baseFolder = _a.baseFolder;
        this.getPath = function () {
            var URI = location.pathname.substring(1);
            var splitURI = URI.split('/');
            var route = splitURI[splitURI.length - 1];
            var path = "" + this.baseFolderPath + route + "/" + (route.charAt(0).toUpperCase() + route.slice(1)) + ".js";
            return path;
        };
        this.load = function () {
            System.import(this.path);
        };
        this.baseFolderPath = baseFolderPath;
        this.path = this.getPath();
        this.load();
    }
    return SystemImports;
}());
