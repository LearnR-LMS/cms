

!function(global,factory){if("function"==typeof define&&define.amd)define("/App/Notebook",["exports","Site"],factory);else if("undefined"!=typeof exports)factory(exports,require("Site"));else{var mod={exports:{}};factory(mod.exports,global.Site),global.AppNotebook=mod.exports}}(this,function(exports,_Site2){"use strict";function getInstance(){return instance||(instance=new AppNotebook),instance}Object.defineProperty(exports,"__esModule",{value:!0}),exports.getInstance=exports.run=exports.AppNotebook=void 0;var AppNotebook=function(_Site){function AppNotebook(){return babelHelpers.classCallCheck(this,AppNotebook),babelHelpers.possibleConstructorReturn(this,(AppNotebook.__proto__||Object.getPrototypeOf(AppNotebook)).apply(this,arguments))}return babelHelpers.inherits(AppNotebook,_Site),babelHelpers.createClass(AppNotebook,[{key:"initialize",value:function(){babelHelpers.get(AppNotebook.prototype.__proto__||Object.getPrototypeOf(AppNotebook.prototype),"initialize",this).call(this),this.$listItem=$(".list-group-item"),this.$actionBtn=$(".site-action"),this.$toggle=this.$actionBtn.find(".site-action-toggle"),this.$newNote=$("#addNewNote"),this.$mdEdit=$("#mdEdit"),this.window=$(window),this.states={listItemActive:!1}}},{key:"process",value:function(){babelHelpers.get(AppNotebook.prototype.__proto__||Object.getPrototypeOf(AppNotebook.prototype),"process",this).call(this),this.handleResize(),this.steupListItem(),this.steupActionBtn()}},{key:"initEditer",value:function(){this.$mdEdit.markdown({autofocus:!1,savable:!1})}},{key:"listItemActive",value:function(active){var api=this.$actionBtn.data("actionBtn");active?api.show():this.$listItem.removeClass("active"),this.states.listItemActive=active}},{key:"steupListItem",value:function(){var self=this;this.$listItem.on("click",function(){$(this).siblings().removeClass("active"),$(this).addClass("active"),self.listItemActive(!0)})}},{key:"steupActionBtn",value:function(){var _this2=this;this.$toggle.on("click",function(e){_this2.states.listItemActive?_this2.listItemActive(!1):(_this2.$newNote.modal("show"),e.stopPropagation())})}},{key:"handleResize",value:function(){this.window.on("resize",this.initEditer())}}]),AppNotebook}(babelHelpers.interopRequireDefault(_Site2).default),instance=null;exports.default=AppNotebook,exports.AppNotebook=AppNotebook,exports.run=function(){getInstance().run()},exports.getInstance=getInstance});