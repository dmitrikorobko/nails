import * as markerimage from '../../images/map-pointer.svg';
import * as markerpng from '../../images/map-pointer.png';

export default {
  init() {

    

    const selectCountries = () => {
        const form = document.querySelector('.registration-form');
        
        const language = form.dataset.language;

        const simpleCountry = document.querySelector('#country');

        const countryRepresent = document.querySelector('#countryRepresent');

        const country = simpleCountry.dataset.country;

        let jsonFile = "/app/json/countries_" + language + ".json";

        let jsonCountries = null;
        let request = new XMLHttpRequest();
        request.open("GET", jsonFile, true);
        request.send(null);
        request.onreadystatechange = function() {
            if ( request.readyState === 4 && request.status === 200 ) {
                jsonCountries = JSON.parse(request.responseText);
                addCountries(countryRepresent, jsonCountries, country);
                addCountries(simpleCountry, jsonCountries, country);
                if(form.id == 'participant'){
                  const invoiceCountry = document.querySelector('#invoiceCountry');
                  addCountries(invoiceCountry, jsonCountries, country);
                }
            }
        }

        function addCountries(el, countries, country){

            for (const c in countries) {
                $(el).append('<option value="' + countries[c] + '">' + countries[c] + '</option>');
            }

            $(el).selectpicker('val', country);
            $(el).selectpicker('refresh');
        }
    }

    const formProcess = () => {

      const form = document.querySelector('.registration-form');

      document.querySelector('#password1').onchange = validatePass;
      document.querySelector('#password2').onchange = validatePass;

      $('.step-btn').on('click', function (e) {
          e.preventDefault();
          window.scrollTo({ top: 0, behavior: 'smooth' });
          let $this = $(this);
          let $thisData = $this.data('step');
          let currentStep = $this.data('current-step');
          if(currentStep != 'last'){
            let step = document.querySelector('.step-item[data-step = '+currentStep+']')
            if(validation(step, form.id)){
              makeStep($thisData);
            }
          } else {
            makeStep($thisData);
          }
      });
      
      $('.submit-btn').on('click', function (e) {
          let currentStep = $(this).data('current-step');
          let step = document.querySelector('.step-item[data-step = '+currentStep+']');
          if(validate(step) === false){
            e.preventDefault();
            e.stopPropagation();
          } 
      });

      if(form.id === 'participant' || form.id === 'sponsor' ){
        validateInvoiceFor();

        fileValidation();
      }

      if(form.id === 'participant'){
        teamsAutocomplete()
        calculatePrice();
        
      }

      $('.registration-form').submit(function(e) {

          submitApi(e);
  
      });

      function teamsAutocomplete(){
        const teams = document.querySelector('.added-teams');
        const teamsSrc = JSON.parse(teams.value);
        
      
  
        $('#team').autocomplete({
          source: teamsSrc,
          highlightClass: 'text-danger',
          treshold: 2,
        });
  
      }

      function fileValidation(){

        $('.form-control-file').on('change',function(){
          let validated = true;
          if (this.files[0].size > 5000000) {

              alert('Big size!')
              validated = false;
          }

          if ( this.files[0].type !== 'image/jpeg' && this.files[0].type !== 'image/png' && this.files[0].type !== 'image/gif') {

              alert('Invalid image type!')
              validated = false;
              

          }

          if(!validated){
              $(this).get(0).value = '';
              $(this).get(0).type = '';
              $(this).get(0).type = 'file';
          }
          
        });

      }

      function validation(step, formType){
        if(formType != 'participant'){
          return (validate(step))
        } else {
          if (validate(step) == true && additionalValidation() == true){
            return true;
          }else{
            return false;
          }
        }
      }

      function additionalValidation() {
        let devision = document.querySelector('input[name="catRadios"]:checked').id;
        let minimumNominations = 1; 
        let minimumOfflineNominations = 0;
        let result = false;
          if(devision === 'cat-3'){
            minimumOfflineNominations = 3;
            result = checkNominations(document.querySelector('#offlineNominations'), minimumOfflineNominations);
            nominationError(result, ".error-message-cat-3", ".error-message-cat-1-2");
          } else {
            result = checkNominations(document.querySelector('.nomination'), minimumNominations);
            nominationError(result, ".error-message-cat-1-2", ".error-message-cat-3");
          }
        return result;
      }

      function nominationError(result, selector, cleaner){
        if(!result){
          document.querySelector(selector).classList.add('show');
          document.querySelector(cleaner).classList.remove('show');
        } else {
          document.querySelector(selector).classList.remove('show');
        }
      }

      function checkNominations(formPart, minimum) {
        let elements = formPart.querySelectorAll(".form-check-input");
        let checkedCount = 0;
        for (let i = 0; i < elements.length; i++) {
          if(elements[i].checked){
            checkedCount++;
          }  
        }
        
        if(checkedCount >= minimum){
          return true;
        } else {
          return false;
        }
      }
      
      function calculatePrice() {
        let devision = 'cat-1';
        let liveEvents = document.querySelector('#offlineNominations').querySelectorAll(".form-check-input");
        let onlineEvents = document.querySelector('#onlineNominations').querySelectorAll(".form-check-input");

        let liveCount = 0;

        let price = 0;
        let priceOnline = 0;
        let finalPrice = 0;
        console.log(finalPrice);
        const firstDev = document.querySelector('.price-1');
        const firstDevPrice = JSON.parse(firstDev.value);

        const secondDev = document.querySelector('.price-2');
        const secondDevPrice = JSON.parse(secondDev.value);

        const thirdDev = document.querySelector('.price-3');
        const thirdDevPrice = JSON.parse(thirdDev.value);
      
        $("input[name='catRadios']").change(function(e){
          devision = e.target.id;
          liveEventsChecks(devision, liveEvents);
          onlineEventsChecks(devision, onlineEvents);
        });

        liveEventsChecks(devision, liveEvents);

        onlineEventsChecks(devision, onlineEvents);

        function onlineEventsChecks(devision, onlineEvents){
          onlineEventsUpdate(devision, onlineEvents);
          for (let i = 0; i < onlineEvents.length; i++) {

            onlineEvents[i].onclick = function(e) {
              
              let event = e.target;
              if(event.checked){
                priceOnline = onlineEventsCalc(event, devision, 'add');
              } else {
                priceOnline = onlineEventsCalc(event, devision, 'remove');
              }
              finalPrice = finalPricaCalc(priceOnline, price);
            };
          }

        }

        function finalPricaCalc(x, y) {
          let z = parseInt(x, 10) + parseInt(y, 10);
          document.getElementById("regPrice").textContent = z.toString();
          document.getElementById("total-price").value = z.toString();
          return z;
        }

        function onlineEventsUpdate(dev, events){
          priceOnline = 0;

          for (let i = 0; i < events.length; i++) {
   
           if(events[i].checked){
              priceOnline = onlineEventsCalc(events[i], dev, 'add');
            }
          }
          console.log("New online price:");
          console.log(priceOnline);
          finalPrice = finalPricaCalc(priceOnline, price);
        }

        function onlineEventsCalc(e, devision, toDo){
          let type = $(e).attr('class').split(' ')[1];
          let onDevPrice; 

          switch (devision) {
            case 'cat-2':
              onDevPrice = secondDevPrice;
              break;
            case 'cat-3':
              onDevPrice = thirdDevPrice;
              break;
            default:
              onDevPrice = firstDevPrice;
          }

          if(toDo === 'add'){
            return priceOnline + parseInt(onDevPrice[type], 10);
          } else {
            return priceOnline - parseInt(onDevPrice[type], 10);
          }
        }

        function liveEventsChecks(devision, liveEvents){
          //let liveCount = 0;
          price = liveEventsCalc(devision, liveCount);
          finalPrice = finalPricaCalc(priceOnline, price);
        
          for (let i = 0; i < liveEvents.length; i++) {
            liveEvents[i].onclick = function(e) {
              
              let event = e.target;
              if(event.checked){
                liveCount++;
              } else {
                liveCount--;
              }
              price = liveEventsCalc(devision, liveCount);
              finalPrice = finalPricaCalc(priceOnline, price);
            };
          }
        }

        function liveEventsCalc(devision, amount){
          let devPrice;
  
          switch (devision) {
            case 'cat-2':
              devPrice = secondDevPrice;
              break;
            case 'cat-3':
              devPrice = thirdDevPrice;
              break;
            default:
              devPrice = firstDevPrice;
          }
  
          if(amount === 1){
            return devPrice.one;
          } else if (amount === 2){
            return devPrice.two;
          } else if (amount >= 3 && devision != 'cat-3') {
            return devPrice.three;
          } else if (amount >= 3 && devision === 'cat-3') {
            if(amount === 3) return devPrice.three;
            if(amount > 3) return devPrice.four;
          } else {
            return 0;
          }
  
        }

      }





      function validate(step) {
        let reqElements = step.querySelectorAll("[required]");
        let result = true;
        for (let i = 0; i < reqElements.length; i++) {
          let element = reqElements[i];
          result = element.checkValidity();
        }
        //
        step.classList.add('was-validated');
        return result;
      }

      function makeStep(step){
        $('.step-item').removeClass('active');
        $('.step-item[data-step = '+step+']').addClass('active');
      }

      function validateInvoiceFor(){
        document.getElementById("invoiceFor").addEventListener("change", displayInvoiceFields);

        function displayInvoiceFields() {
          let invoiceFor = document.getElementById("invoiceFor").value;
          if(invoiceFor != 'private'){
            if(invoiceFor === 'eu-legal'){
              document.querySelector('#invoice-additional-reg').classList.add('hide');
              document.querySelector('#invoice-additional-vat').classList.remove('hide');
              if(form.id === 'participant'){
                document.querySelectorAll('#invoice-additional').forEach(div => div.classList.remove('hide'));
              }
            } else {
              if(form.id === 'participant'){
                document.querySelector('#invoice-additional-vat').classList.add('hide');
                document.querySelector('#invoice-additional-reg').classList.remove('hide');
                document.querySelectorAll('#invoice-additional').forEach(div => div.classList.remove('hide'));
              }
            }
          } else {
            document.querySelector('#invoice-additional-vat').classList.add('hide');
            document.querySelector('#invoice-additional-reg').classList.add('hide');
            document.querySelectorAll('#invoice-additional').forEach(div => div.classList.add('hide'));
          }
        }
      }

      function validatePass(){
        const pass = document.querySelector('#password1');
        const passRepeater = document.querySelector('#password2');
        passRepeater.setCustomValidity(passRepeater.value != pass.value ? "Passwords do not match." : "")
      }


      function submitApi(e){
        e.preventDefault();
        // eslint-disable-next-line no-undef
        $('.main').addClass('processing').append(form_global.preloader);


        let data = new FormData(form);


        $('[type="file"]').each(function(){
          let file_data = $(this)[0];
          data.append('file', file_data);
        })


        $.ajax({
          // eslint-disable-next-line no-undef
          url : form_global.url,
          type: 'POST',
          data : data,
          cache: false,
          contentType: false,
          processData: false,
          success: function (response) {

            if(response.success) {
              $('.lds-ripple').remove();
              $('#modalRegistration').modal('show');

              $('.reg-success').removeClass('hide');
              $('.reg-message').removeClass('hide');

              $('.reg-wrong').addClass('hide');
              $('.reg-error-message').addClass('hide');

              successRegModalClose();

            } else {
              $('.main').removeClass('processing') ;
              $('.lds-ripple').remove();
              
              $('.reg-success').addClass('hide');
              $('.reg-message').addClass('hide');

              $('.reg-wrong').removeClass('hide');
              $('.reg-error-message').removeClass('hide');

              $('.reg-error-message').append(response.message);

              $('#modalRegistration').modal('show');
            }

            console.log("Here is response:");
            console.log(response);
          }
        })

      }

      function successRegModalClose(){
        $('#modalRegistration').on('hide.bs.modal', function () {
          window.location.href = document.getElementById("modalLogin").href;
        });
      }

      
    }

    if(document.querySelector(".registration-form")){
      selectCountries();
      formProcess();
    }

  },
  finalize() {

    const google = window.google;
    // JavaScript to be fired on all pages, after page specific JS is fired
    $(function initMap() { // eslint-disable-line no-unused-vars
      
      const uluru = { lat: 59.4107196, lng: 24.6808191 };

      const center = { lat: 59.4107196, lng: 24.6808191 };

      const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 15,
          center: center,
          gestureHandling: 'none', 
          disableDefaultUI: true,
      });
      
      //const image ="../images/map-pointer.svg";
      const icon = { // eslint-disable-line no-unused-vars
          url: markerpng,
          size: new google.maps.Size(30, 43.15),
          scaledSize: new google.maps.Size(30, 43.15)
      };
      const marker = new google.maps.Marker({ // eslint-disable-line no-unused-vars
          position: uluru,
          map: map,
          icon: markerimage,
    

      });
      var styles = 
      [
          {
              "featureType": "water",
              "elementType": "geometry",
              "stylers": [
                  {
                      "color": "#e9e9e9"
                  },
                  {
                      "lightness": 17
                  }
              ]
          },
          {
              "featureType": "landscape",
              "elementType": "geometry",
              "stylers": [
                  {
                      "color": "#f5f5f5"
                  },
                  {
                      "lightness": 20
                  }
              ]
          },
          {
              "featureType": "road.highway",
              "elementType": "geometry.fill",
              "stylers": [
                  {
                      "color": "#ffffff"
                  },
                  {
                      "lightness": 17
                  }
              ]
          },
          {
              "featureType": "road.highway",
              "elementType": "geometry.stroke",
              "stylers": [
                  {
                      "color": "#ffffff"
                  },
                  {
                      "lightness": 29
                  },
                  {
                      "weight": 0.2
                  }
              ]
          },
          {
              "featureType": "road.arterial",
              "elementType": "geometry",
              "stylers": [
                  {
                      "color": "#ffffff"
                  },
                  {
                      "lightness": 18
                  }
              ]
          },
          {
              "featureType": "road.local",
              "elementType": "geometry",
              "stylers": [
                  {
                      "color": "#ffffff"
                  },
                  {
                      "lightness": 16
                  }
              ]
          },
          {
              "featureType": "poi",
              "elementType": "geometry",
              "stylers": [
                  {
                      "color": "#f5f5f5"
                  },
                  {
                      "lightness": 21
                  }
              ]
          },
          {
              "featureType": "poi.park",
              "elementType": "geometry",
              "stylers": [
                  {
                      "color": "#dedede"
                  },
                  {
                      "lightness": 21
                  }
              ]
          },
          {
              "elementType": "labels.text.stroke",
              "stylers": [
                  {
                      "visibility": "on"
                  },
                  {
                      "color": "#ffffff"
                  },
                  {
                      "lightness": 16
                  }
              ]
          },
          {
              "elementType": "labels.text.fill",
              "stylers": [
                  {
                      "saturation": 36
                  },
                  {
                      "color": "#333333"
                  },
                  {
                      "lightness": 40
                  }
              ]
          },
          {
              "elementType": "labels.icon",
              "stylers": [
                  {
                      "visibility": "off"
                  }
              ]
          },
          {
              "featureType": "transit",
              "elementType": "geometry",
              "stylers": [
                  {
                      "color": "#f2f2f2"
                  },
                  {
                      "lightness": 19
                  }
              ]
          },
          {
              "featureType": "administrative",
              "elementType": "geometry.fill",
              "stylers": [
                  {
                      "color": "#fefefe"
                  },
                  {
                      "lightness": 20
                  }
              ]
          },
          {
              "featureType": "administrative",
              "elementType": "geometry.stroke",
              "stylers": [
                  {
                      "color": "#fefefe"
                  },
                  {
                      "lightness": 17
                  },
                  {
                      "weight": 1.2
                  }
              ]
          }
      ]
      map.set('styles', styles);
      return map;
  })
  },
};
