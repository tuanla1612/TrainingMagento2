define([
    'jquery',
    'uiComponent',
    'ko'
], function ($, Component, ko) {
    'use strict';
    let customData = window.customConfig;
    //console.log(customData);
    if(customData == null){
        let id = 0;
        return Component.extend({
            defaults: {
                template: 'Magenest_Blog/dynamic-row'
            },

            initialize: function () {
                //console.log(customData);
                this.options = ko.observableArray([]);
                this._super();
                this.addColor = function(){
                    id++;
                    let nameColor = "groups[color_picker][fields][background_color][value][_"+ id +"][color]";
                    let nameColorCode = "groups[color_picker][fields][background_color][value][_"+ id +"][code]";


                    this.options.push({
                        ids: id,
                        color_name: "",
                        color_code: "",
                        nameColor: nameColor,
                        nameColorCode: nameColorCode
                    });
                };
                this.deleteRecord = function (id){
                    this.options.destroy(id)
;

                };
            },

        });
    }else{




                return Component.extend({
                    defaults: {
                        template: 'Magenest_Blog/dynamic-row'
                    },

                    initialize: function () {
                        let array = [];
                        this.options = ko.observableArray([]);
                        let count = 0;

                        for(let key in customData) {
                            if (customData.hasOwnProperty(key)) {
                                    let tmp = Object.keys(customData)[count];
                                    let id = tmp.split('')[1];
                                    if(array.includes(parseInt(id))){
                                        for(let i=0;i< array.length;i++){
                                            if(array[i] === parseInt(id)){
                                                array.splice(i,1);
                                            }
                                        }
                                    }
                                    if(parseInt(id) !== (count + 1)){
                                        for(let i=count;i<parseInt(id);i++){
                                            if((i+1) < parseInt(id) && !array.includes(i+1)){
                                                array.push(i+1);
                                            }
                                        }
                                    }
                                    let nameColor = "groups[color_picker][fields][background_color][value][_" + id + "][color]";
                                    let nameColorCode = "groups[color_picker][fields][background_color][value][_" + id + "][code]";
                                    let name = customData[key].color;
                                    let code = customData[key].code;
                                    this.options.push({
                                        ids: id,
                                        color_name: name,
                                        color_code: code,
                                        nameColor: nameColor,
                                        nameColorCode: nameColorCode
                                    });

                                count++;
                                //console.log(this.options);
                                //console.log(this.options._latestValue);
                                this._super();

                                this.addColor = function () {
                                    if(array.length === 0){
                                        tmp = count + 1;
                                    }else{
                                        tmp = array.pop();
                                    }
                                    console.log(this.options);
                                    console.log(tmp);
                                    count ++;
                                    let nameColor = "groups[color_picker][fields][background_color][value][_" + tmp + "][color]";
                                    let nameColorCode = "groups[color_picker][fields][background_color][value][_" + tmp + "][code]";
                                    
                                    this.options.push({
                                        ids: tmp.toString(),
                                        color_name: "",
                                        color_code: "",
                                        nameColor: nameColor,
                                        nameColorCode: nameColorCode
                                    });
                                    console.log(this.options);
                                };

                                this.deleteRecord = function (parent) {
                                    console.log(parent);
                                    count--;
                                    if(!array.includes(parseInt(parent.ids))){
                                        array.push(parseInt(parent.ids));
                                    }
                                    //console.log(array);
                                    for(let i = 0;i < this.options._latestValue.length;i++){
                                        if(this.options._latestValue[i].ids === parent.ids){
                                            this.options.splice(i, 1);
                                        }
                                    }
                                    console.log(this.options);
                                };
                            }

                        }
                        

                    }
                });

    }

});