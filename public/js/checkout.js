$(document).ready(function(){
  $('.payment-methods .list-content label').click(function() {
    $('.payment-methods .list-content>li').removeClass('active');
    $(this).parent('li').addClass('active');
  });
});
$(document).ready(function() {
    // Initial setup: set the shipping price based on the initially selected radio button
    updateShippingPrice();

    // Listen for changes in the selected radio button
    $("input[name='shipping_method']").on("change", function() {
        updateShippingPrice();
    });

    // Function to update the shipping price
    function updateShippingPrice() {
        var selectedPrice = parseInt($("input[name='shipping_method']:checked").val()); // Convert value to integer
        // Update the displayed shipping price
        $(".ship-price .price").text(formatCurrency(selectedPrice));

        // Update the total price: Calculate new totalPrice = cart totalPrice + selected shipping fee
        var currentTotalPrice = parseInt($(".total-price .price").attr("data-price")); // Get the current total price from the data attribute
        var newTotalPrice = currentTotalPrice + selectedPrice; // Add shipping fee to current total price

        // Update the total price display
        $(".total-price .price").text(formatCurrency(newTotalPrice));
        $(".total-price").attr("data-price", newTotalPrice); // Update the data-price attribute with the new total price
        // call ajax to update fee
        var token = $('meta[name="csrf-token"]').attr('content');
        var url = $("input[name='shipping_method']").attr('data-route-update-fee');
        var data = {
            _token: token,
            fee: selectedPrice
        };
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: 'JSON',
            error: function(data) {
                var errors = data.responseJSON;
                Swal.fire({
                    title: 'Thất bại',
                    text: errors.msg,
                    type: 'error'
                })
            }
        });
    }

    // Function to format the currency
    function formatCurrency(value) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
        }).format(value);
    }
});


// validate form

$(document).ready(function(){
  var constraints = {
    email: {
      presence: {
        message: "^Email không được trống!"
      },
      email: {
        message: "^Email không đúng định dạng!"
      }
    },
    name: {
      presence: {
        message: "^Tên không được trống!"
      },
      length: {
        minimum: 3,
        maximum: 25,
        message: "^Độ dài từ 3 đến 25 ký tự"
      }
    },
    phone: {
      presence: {
        message: "^Số điện thoại không được trống!"
      },
      format: {
        pattern: "0[^6421][0-9]{8}",
        flags: "i",
        message: "^Số điện thoại không đúng định dạng!"
      }
    },
    address: {
      presence: {
        message: "^Địa chỉ không được trống!"
      }
    },
  };
  var form_checkout = $('.form-checkout>form');
  var form = document.querySelector('.form-checkout>form');

  var inputs = document.querySelectorAll(".form-checkout>form input, .form-checkout>form textarea, .form-checkout>form select")

  for (var i = 0; i < inputs.length; ++i) {
    inputs.item(i).addEventListener("change", function(ev) {
      var errors = validate(form, constraints) || {};
      showErrorsForInput(this, errors[this.name])
    });
  }

  $('button[type="submit"]').click(function() {

    var errors = validate(form, constraints);
    showErrors(form, errors || {});

    if(!errors) {
      var token = $('meta[name="csrf-token"]').attr('content');
      form_checkout.append($('<input type="hidden" name="_token">').val(token));

      var payment_method = $('input[name="payment_method"]:checked').val();
      form_checkout.append($('<input type="hidden" name="payment_method">').val(payment_method));

      var shipping_method = $('input[name="shipping_method"]:checked').val();
      form_checkout.append($('<input type="hidden" name="shipping_method">').val(shipping_method));
      var buy_method = form_checkout.attr('buy-method');
      form_checkout.append($('<input type="hidden" name="buy_method">').val(buy_method));

      if(buy_method == 'buy_now') {
        var product = $('.col-order .col-content .section-items .item').attr('data-product');
        form_checkout.append($('<input type="hidden" name="product_id">').val(product));

        var qty = $('.col-order .col-header h2 span').attr('data-qty');
        form_checkout.append($('<input type="hidden" name="totalQty">').val(qty));

        var price = $('.col-order .col-content .section-items .item').attr('data-price');
        form_checkout.append($('<input type="hidden" name="price">').val(price));
      }
      form_checkout.submit();
    }
  });

});

// Updates the inputs with the validation errors
function showErrors(form, errors) {
  // We loop through all the inputs and show the errors for that input
  _.each(form.querySelectorAll(".form-checkout>form input[name], .form-checkout>form select[name]"), function(input) {
    // Since the errors can be null if no errors were found we need to handle
    // that
    showErrorsForInput(input, errors && errors[input.name]);
  });
}

// Shows the errors for a specific input
function showErrorsForInput(input, errors) {
  // This is the root of the input
  var formGroup = closestParent(input.parentNode, "form-group")
    // Find where the error messages will be insert into
    ,
    messages = formGroup.querySelector(".messages");
  // First we remove any old messages and resets the classes
  resetFormGroup(formGroup);
  // If we have errors
  if (errors) {
    // we first mark the group has having errors
    formGroup.classList.add("has-error");
    // then we append all the errors
    _.each(errors, function(error) {
      addError(messages, error);
    });
  } else {
    // otherwise we simply mark it as success
    formGroup.classList.add("has-success");
  }
}

// Recusively finds the closest parent that has the specified class
function closestParent(child, className) {
  if (!child || child == document) {
    return null;
  }
  if (child.classList.contains(className)) {
    return child;
  } else {
    return closestParent(child.parentNode, className);
  }
}

function resetFormGroup(formGroup) {
  // Remove the success and error classes
  formGroup.classList.remove("has-error");
  formGroup.classList.remove("has-success");
  // and remove any old messages
  _.each(formGroup.querySelectorAll(".help-block.error"), function(el) {
    el.parentNode.removeChild(el);
  });
}

// Adds the specified error with the following markup
// <p class="help-block error">[message]</p>
function addError(messages, error) {
  var block = document.createElement("p");
  block.classList.add("help-block");
  block.classList.add("error");
  block.innerText = error;
  messages.appendChild(block);
}
