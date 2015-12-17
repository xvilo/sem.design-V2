//nice fitting headers
$(".name").fitText(0.59);
$("h6").fitText(1.85);
$(".media").fitText(0.79);
$(".internship").fitText(1.32);
$(".beautifullcode").fitText(1.03);

//phone verifcation modal etc
$("a[rel*=leanModal]").leanModal();
$("#phone").intlTelInput({
  defaultCountry: "auto",
  geoIpLookup: function(callback) {
    $.get('https://ip.nf/me.json', function() {}, "jsonp").always(function(resp) {
      var countryCode = (resp && resp.ip.country_code) ? resp.ip.country_code : "";
      callback(countryCode);
    });
  },
  utilsScript: "js/utils.js" // just for formatting/placeholders etc
});

// update the hidden input on submit
$("#resume_form").submit(function() {
  $("#hidden").val($("#phone").intlTelInput("getNumber"));
});