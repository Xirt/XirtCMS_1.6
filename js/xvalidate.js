var XValidator=new Class({Extends:Form.Validator.Inline,initialize:function(b,a){a=a?a:{};a.onElementFail=function(e,d){d=(typeOf(d)=="array")?d.getLast():d;
var c=e.title?e.title:XLang.validation[d.split(":")[0]];e.tooltip?e.tooltip.update(c):new Tooltip(e,c);};a.onElementPass=function(c){return(c.tooltip&&c.tooltip.hide());
};a.showError=function(){};this.parent(b,a);}});Form.Validator.add("validate-simple",{test:function(a){var b=/^[a-zA-Z0-9._-]+$/;return(!a.value||b.test(a.value));
}});Form.Validator.add("validate-password",{test:function(c){var d=/^[0-9a-zA-Z!@#$%^&*()]*$/;if(!d.test(c.value)){return false;}var b=+(c.value.length>5);
var d=new Array(/[a-z]+/,/[A-Z]+/,/[0-9]+/);for(var a=0;a<d.length;a++){b=(d[a].test(c.value))?(b+1):b;}return(b>3);}});Form.Validator.add("validate-phone",{test:function(a){var b=/^[0-9\s\(\)\+\-]+$/;
return(!a.value||b.test(a.value));}});