System.register(["./HelloMessage.js"], function (exports_1, context_1) {
    "use strict";
    var HelloMessage_js_1, HelloMessage;
    var __moduleName = context_1 && context_1.id;
    return {
        setters: [
            function (HelloMessage_js_1_1) {
                HelloMessage_js_1 = HelloMessage_js_1_1;
            }
        ],
        execute: function () {
            console.log(HelloMessage_js_1.HelloMessage);
            exports_1("HelloMessage", HelloMessage = HelloMessage_js_1.HelloMessage);
        }
    };
});
