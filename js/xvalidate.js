var XValidator=new Class({Extends:Form.Validator.Inline,initialize:function(form,options){options=options?options:{};options.onElementFail=function(el,check){check=(typeOf(check)=="array")?check.getLast():check;
var txt=el.title?el.title:XLang.validation[check.split(":")[0]];el.pointer?el.pointer.update(txt):new Pointer(el,txt);};options.onElementPass=function(el){return(el.pointer&&el.pointer.hide());
};options.showError=function(){};this.parent(form,options);}});Form.Validator.add("validate-simple",{test:function(el){var regex=/^[a-zA-Z0-9._-]+$/;
return(!el.value||regex.test(el.value));}});Form.Validator.add("validate-password",{test:function(el){var regex=/^[0-9a-zA-Z!@#$%^&*()]*$/;
if(!regex.test(el.value)){return false;}var s=+(el.value.length>5);var regex=new Array(/[a-z]+/,/[A-Z]+/,/[0-9]+/);for(var i=0;
i<regex.length;i++){s=(regex[i].test(el.value))?(s+1):s;}return(s>3);}});Form.Validator.add("validate-phone",{test:function(el){var regex=/^[0-9\s\(\)\+\-]+$/;
return(!el.value||regex.test(el.value));}});