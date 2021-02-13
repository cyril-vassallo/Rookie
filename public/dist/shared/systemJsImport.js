"use strict";
var SysJs = (function () {
    function SysJs() {
        this.getRoute = function () {
            var path = location.pathname.substring(1);
            var splitPath = path.split('/');
            return splitPath[splitPath.length - 1];
        };
        this.load = function (route) {
            if (route === 'home') {
                System.import('./public/dist/pages/home/Home.js');
            }
        };
        this.route = this.getRoute();
        this.load(this.route);
    }
    return SysJs;
}());
