var Stripe = Stripe || {};
var jQuery = jQuery || {};

// this identifies your website in the createToken call below
Stripe.setPublishableKey('STRIPE-PUBLISHABLE-API-KEY');

function stripeResponseHandler(status, response) {
	if (response.error) {
		// re-enable the submit button
		$('.submit-button').removeAttr("disabled");
		// show the errors on the form
		$(".payment-errors").html(response.error.message);
	} else {
		var form$ = $("#payment-form"),
		// token contains id, last4, and card type
			token = response['id'];
		// insert the token into the form so it gets submitted to the server
		form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
		// and submit
		form$.get(0).submit();
	}
}

$(document).ready(function () {
	$("#payment-form").submit(function (event) {
		// disable the submit button to prevent repeated clicks
		$('.submit-button').attr("disabled", "disabled");

		// createToken returns immediately - the supplied callback submits the form if there are no errors
		Stripe.createToken({
			number: $('.card-number').val(),
			cvc: $('.card-cvc').val(),
			exp_month: $('.card-expiry-month').val(),
			exp_year: $('.card-expiry-year').val()
		}, stripeResponseHandler);
		return false; // submit from callback
	});

	$('textarea[maxlength]').charactersRemaining();

	if (document.getElementById('charges')) {
		new Tablesort(document.getElementById('charges'));
	}
});

/*!
* tablesort v1.6.1 (2013-11-08)
* http://tristen.ca/tablesort/demo
* Copyright (c) 2013 ; Licensed MIT
*/
(function(){function e(e,t){if(e.tagName!=="TABLE")throw new Error("Element must be a table");this.init(e,t||{})}e.prototype={init:function(e,t){var n=this,r;this.thead=!1,this.options=t,this.options.d=t.descending||!1,e.rows&&e.rows.length>0&&(e.tHead&&e.tHead.rows.length>0?(r=e.tHead.rows[e.tHead.rows.length-1],n.thead=!0):r=e.rows[0]);if(!r)return;var i=function(e){var t=o(u,"tr").getElementsByTagName("th");for(var r=0;r<t.length;r++)(c(t[r],"sort-up")||c(t[r],"sort-down"))&&t[r]!==this&&(t[r].className=t[r].className.replace(" sort-down","").replace(" sort-up",""));n.current=this,n.sortTable(this)};for(var s=0;s<r.cells.length;s++){var u=r.cells[s];c(u,"no-sort")||(u.className+=" sort-header",h(u,"click",i))}},sortTable:function(e,t){var n=this,r=e.cellIndex,h,p=o(e,"table"),d="",v=0;if(p.rows.length<=1)return;while(d===""&&v<p.tBodies[0].rows.length){d=u(p.tBodies[0].rows[v].cells[r]),d=f(d);if(d.substr(0,4)==="<!--"||d.length===0)d="";v++}if(d==="")return;var m=function(e,t){var r=u(e.cells[n.col]).toLowerCase(),i=u(t.cells[n.col]).toLowerCase();return r===i?0:r<i?1:-1},g=function(e,t){var r=u(e.cells[n.col]),i=u(t.cells[n.col]);return r=l(r),i=l(i),a(i,r)},y=function(e,t){var r=u(e.cells[n.col]).toLowerCase(),i=u(t.cells[n.col]).toLowerCase();return s(i)-s(r)};d.match(/^-?[£\x24Û¢´]\d/)||d.match(/^-?(\d+[,\.]?)+(E[\-+][\d]+)?%?$/)?h=g:i(d)?h=y:h=m,this.col=r;var b=[],w=0;for(v=0;v<p.tBodies.length;v++)if(!n.thead)for(w=1;w<p.tBodies[v].rows.length;w++)b[w-1]=p.tBodies[v].rows[w];else for(w=0;w<p.tBodies[v].rows.length;w++)b[w]=p.tBodies[v].rows[w];b.sort(h),t||(n.options.d?c(e,"sort-up")?(e.className=e.className.replace(/ sort-up/,""),e.className+=" sort-down"):(e.className=e.className.replace(/ sort-down/,""),e.className+=" sort-up"):c(e,"sort-down")?(e.className=e.className.replace(/ sort-down/,""),e.className+=" sort-up"):(e.className=e.className.replace(/ sort-up/,""),e.className+=" sort-down")),c(e,"sort-down")&&b.reverse();for(v=0;v<b.length;v++)c(b[v],"no-sort")||p.tBodies[0].appendChild(b[v])},refresh:function(){this.current!==undefined&&this.sortTable(this.current,!0)}};var t=/(Mon|Tue|Wed|Thu|Fri|Sat|Sun)\.?\,?\s*/i,n=/\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4}/,r=/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)/i,i=function(e){return(e.search(t)!==-1||e.search(n)!==-1||e.search(r!==-1))!==-1&&!isNaN(s(e))},s=function(e){return e=e.replace(/\-/g,"/"),e=e.replace(/(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{2})/,"$1/$2/$3"),(new Date(e)).getTime()},o=function(e,t){return e===null?null:e.nodeType===1&&e.tagName.toLowerCase()===t.toLowerCase()?e:o(e.parentNode,t)},u=function(e){var t=this;if(typeof e=="string"||typeof e=="undefined")return e;var n=e.getAttribute("data-sort")||"";if(n)return n;if(e.textContent)return e.textContent;if(e.innerText)return e.innerText;var r=e.childNodes,i=r.length;for(var s=0;s<i;s++)switch(r[s].nodeType){case 1:n+=t.getInnerText(r[s]);break;case 3:n+=r[s].nodeValue}return n},a=function(e,t){var n=parseFloat(e),r=parseFloat(t);return e=isNaN(n)?0:n,t=isNaN(r)?0:r,e-t},f=function(e){return e.replace(/^\s+|\s+$/g,"")},l=function(e){return e.replace(/[^\-?0-9.]/g,"")},c=function(e,t){return(" "+e.className+" ").indexOf(" "+t+" ")>-1},h=function(e,t,n){e.attachEvent?(e["e"+t+n]=n,e[t+n]=function(){e["e"+t+n](window.event)},e.attachEvent("on"+t,e[t+n])):e.addEventListener(t,n,!1)};typeof module!="undefined"&&module.exports?module.exports=e:window.Tablesort=e})();



/*
	
	@charactersRemaining jQuery Plugin
	7.7.08 - pdf, 11.5.13 - wm
	
	in your js:
	$(".charactersremaining").charactersRemaining();

*/

jQuery.fn.charactersRemaining = function () {
	
    // prevent elem has no properties error
    if (this.length === 0) { return (this); }
	
	function Cr($obj) {
		var counter = {
			$target		: $obj,
			maxvalue	: $obj.attr('maxlength'),
			remaining	: null,
			
			init : function () {
				// setting this as property of counter was leaving maxvalue undefined? lookup timing?
				var template = '<label class="counter"><span>' + counter.remaining + '</span> of ';
				template += '<b>' + counter.maxvalue + '</b> characters remaining</label>';

				$obj.after(template);
				counter.remaining = counter.maxvalue - counter.$target.val().length;
				$obj.next('.counter').find('span').text(counter.remaining);
				counter.$target.bind("keyup keydown", counter.tally);
			},
			
			tally : function () {
				// snip it
				if (counter.$target.val().length > counter.maxvalue) {
					counter.$target.val(counter.$target.val().substring(0, counter.maxvalue));
				}

				$obj.next('.counter').find('span').text(counter.maxvalue - counter.$target.val().length);
			}
		};
		// init the counter
		counter.init($obj);
	}
	return this.each(function () {
		new Cr(jQuery(this));
	});
};

// end charactersRemaining
