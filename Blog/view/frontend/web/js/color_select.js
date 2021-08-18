define([
    'jquery',
    'uiComponent',
    'ko'
], function ($, Component, ko) {
    'use strict';
    let customData = window.customConfig;
    //console.log(customData);
    if(customData == null){
        return Component.extend({
            defaults: {
                template: 'Magenest_Blog/color_select'
            },

            initialize: function () {
                //console.log(customData);
                this.options = ko.observableArray([]);
                this.selectedColor = ko.observable();
                this._super();

                this.options.push({
                    colorName: "default",
                    colorCode: "#FFFFFF",
                });

                this.changeColor = function(){
                    alert("Oke");
                }
            },

        });
    }else{
                return Component.extend({
                    defaults: {
                        template: 'Magenest_Blog/color_select'
                    },

                    initialize: function () {
                        let count = 0;
                        this.options = ko.observableArray([]);
                        this.selectedColor = ko.observable();
                        this._super();

                        this.options.push({
                            colorName: "default",
                            colorCode: "#FFFFFF",
                        });

                        for(let key in customData) {
                            if (customData.hasOwnProperty(key)) {
                                    let tmp = Object.keys(customData)[count];

                                    let name = customData[key].color;
                                    let code = customData[key].code;
                                    this.options.push({
                                        colorName: name,
                                        colorCode: code
                                    });

                                count++;
                                this._super();
                            }
                        }

                        this.selectedColor = ko.observable();

                        this.selectedColor.subscribe(function(latest) {
                            console.log(latest);
                            $('body').css("background-color",latest);
                          }, this);
                        
                    }
                });

    }

});