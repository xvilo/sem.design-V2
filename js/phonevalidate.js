var telInput = jQuery("#billing_phone");
        
telInput.after( '<span id="valid-msg" style="position: absolute;" class="hide">✓ Valid</span>' );
telInput.after( '<span id="error-msg" style="position: absolute;" class="hide">Invalid number</span>' );


  var errorMsg = jQuery("#error-msg"),
  validMsg = jQuery("#valid-msg");


// on blur: validate
telInput.blur(function() {
  if (jQuery.trim(telInput.val())) {
    if (telInput.intlTelInput("isValidNumber")) {
      validMsg.removeClass("hide");
      var nationalPhone = telInput.intlTelInput("getNumber");
      console.log("country code: ", nationalPhone);
      telInput.val(nationalPhone);
    } else {
      telInput.addClass("error");
      errorMsg.removeClass("hide");
      validMsg.addClass("hide");
    }
  }
});

// on keydown: reset
telInput.keydown(function() {
  telInput.removeClass("error");
  errorMsg.addClass("hide");
  validMsg.addClass("hide");
});