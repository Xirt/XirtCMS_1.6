var XUpload=new Class({Implements:[Events,Options],ID_KEY:"APC_UPLOAD_PROGRESS",options:{delay:5},initialize:function(a){if((this.form=$(a.form))&&!this.form){return false;
}this.setOptions(a);this._setProgressBar();this._setTarget();this._setAPC();this.form.addEvent("submit",this._onSubmit.bind(this));
},_setProgressBar:function(){if(!$(this.options.progressBar)){this.options.progressBar=new Element("div");}},_setTarget:function(){if(!this.form.target){var a=Number.random(0,1000);
this.form.target=a;new Element("iframe",{name:a}).hide().inject(this.form);}},_setAPC:function(){if(!this.form[this.ID_KEY]){this.apc=new Element("input",{name:this.ID_KEY,type:"hidden"}).inject(this.form,"top");
}this.apc=Number.random(0,9999);this.form[this.ID_KEY].value=this.apc;},_onSubmit:function(a){this.progressBar=new Fx.XProgressBar(this.options.progressBar);
if(this.options.progressBar){this.progressBar.start(0);}this.fireEvent("start");this._retrieve();},_retrieve:function(){new Request.JSON({url:"index.php",onFailure:Xirt.showError,onSuccess:this._receive.bind(this)}).post({content:"adm_helper",task:"show_upload_progress",id:this.apc});
},_receive:function(a){this.progressBar.set(a.percent);if(!a.finished){this._retrieve.delay(this.options.delay,this,a.id);
return this.fireEvent("update");}if(a.error){this.progressBar.hide();Xirt.showNotice(a.error);return this.fireEvent("failure");
}this.progressBar.hide();Xirt.showNotice(XLang.messages.success);return this.fireEvent("complete");}});Fx.XProgressBar=new Class({Extends:Fx,options:{transition:Fx.Transitions.Circ.easeOut,topClass:"xProgressBox",barClass:"xProgressBar"},initialize:function(b,a){this.setOptions(a);
var d=this.options.topClass;var c=this.options.barClass;this.container=$(b).hide();this.container.addClass(d);if((this.bar=this.container.getElement(c))||!this.bar){this.bar=new Element("div",{"class":c}).inject(this.container);
}this.parent(a);},start:function(){this.set(0);this.show();},set:function(a){var b=this.container.getComputedSize({styles:[]}).width/100;
this.bar.setStyle("width",Math.round(a*b)+"px");this.now=a;},show:function(){this.container.reveal();},hide:function(){this.container.dissolve();
}});