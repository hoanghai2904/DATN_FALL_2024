$(document).ready(function(){
  var key = '0-0';
  var slider = displayGallery(key);

  $("#slide-advertise").owlCarousel({
    items: 2,
    autoplay: true,
    loop: true,
    margin: 10,
    autoplayHoverPause: true,
    nav: true,
    dots: false,
    responsive:{
      0:{
        items: 1,
      },
      992:{
        items: 2,
        animateOut: 'zoomInRight',
        animateIn: 'zoomOutLeft',
      }
    },
    navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>']
  });
  var height_description = $('#description').height();

  if(height_description > 768) {
    $('#description').animate({
      height: '768px',
    }, 500);
    $('#description .loadmore').css('display', 'block');
  }

  $('#description .loadmore a').click(function() {
    $('#description').animate({
      height: height_description + 20 +'px',
    }, 500);
    $('#description .loadmore').css('display', 'none');
    $('#description .hidemore').css('display', 'block');
  });

  $('#description .hidemore a').click(function() {
    $('#description').animate({
      height: '768px',
    }, 500);
    $('#description .loadmore').css('display', 'block');
    $('#description .hidemore').css('display', 'none');
  });

  $(".rating-product").rate();

  if($('.color-product .color-inner.active').attr('can-buy') == 0)
    $('.form-payment .row>div>button').prop('disabled', true);

  $('.select-color .color-inner').click(function() {
    var colorKey = $(this).attr('data-key');
    var selectedSizeKey = $('.select-size .size-inner.active').attr('data-key') ?? '0';  // Lấy key của màu đã chọn
    if (!$(this).hasClass("active")) {
        // Chuyển đổi trạng thái giữa các màu
        $('.select-color .color-inner').removeClass('active');
        $(this).addClass('active');
        $('.select-size .size-inner').removeClass('active');
        var first = false;
        $('.select-size .size-inner').each(function() {
            var dataColorKey = $(this).attr('data-color-key');
            if(dataColorKey == colorKey) {
                $(this).css('display', 'block');
                if(!first) {
                    $(this).addClass('active');
                    first = true;
                }
            } else {
                $(this).css('display', 'none');
            }
        });
        
        // Ẩn tất cả các sản phẩm và chỉ hiển thị sản phẩm của màu đã chọn
        $('.price-product>div').css('display', 'none');
        $('.price-product>.product-' + colorKey + '-' + selectedSizeKey).css('display', 'block');
        
        // Nếu slider tồn tại, hủy và khởi tạo lại
        if (slider && typeof slider.destroy === 'function') slider.destroy();
        $('.section-infomation .image-product>div').css('display', 'none');
        $('.section-infomation .image-product>.image-gallery-' + colorKey+ '-'+selectedSizeKey).css('display', 'block');
        
        slider = displayGallery(colorKey+'-'+selectedSizeKey);
    }

    // Cập nhật giá trị có thể mua cho số lượng (can-buy)
    var canBuy = $(this).attr('can-buy');
    $('#qty').val(canBuy);

    // Nếu không thể mua, vô hiệu hóa nút thanh toán
    $('.form-payment .row>div>button').prop('disabled', canBuy == 0);

    // Cập nhật số lượng tối đa có thể chọn
    var qty = $(this).attr('data-qty');
    $('#qty').attr('max', qty);
  });

  $('.select-size .size-inner').click(function() {
      var sizeKey = $(this).attr('data-key');
      console.log('sizeKey', sizeKey)
      var selectedColorKey = $('.select-color .color-inner.active').attr('data-key');  // Lấy key của size đã chọn
      if (!$(this).hasClass("active")) {
          // Chuyển đổi trạng thái giữa các kích thước
          $('.select-size .size-inner').removeClass('active');
          $(this).addClass('active');
          
          // Ẩn tất cả các sản phẩm và chỉ hiển thị sản phẩm của kích thước đã chọn trong màu đã chọn
          $('.price-product>div').css('display', 'none');
          console.log($('.price-product>.product-' + selectedColorKey + '-' + sizeKey))
          $('.price-product>.product-' + selectedColorKey + '-' + sizeKey).css('display', 'block');
          
          // Nếu slider tồn tại, hủy và khởi tạo lại
          if (slider && typeof slider.destroy === 'function') slider.destroy();
          $('.section-infomation .image-product>div').css('display', 'none');
          $('.section-infomation .image-product>.image-gallery-' + selectedColorKey + '-' + sizeKey).css('display', 'block');
          
          slider = displayGallery(selectedColorKey + '-' + sizeKey);
      }

      // Cập nhật giá trị có thể mua cho số lượng (can-buy) khi chọn kích thước
      var canBuy = $(this).attr('can-buy');
      $('#qty').val(canBuy);

      // Nếu không thể mua, vô hiệu hóa nút thanh toán
      $('.form-payment .row>div>button').prop('disabled', canBuy == 0);

      // Cập nhật số lượng tối đa có thể chọn
      var qty = $(this).attr('data-qty');
      $('#qty').attr('max', qty);
  });

  $('button.add_to_cart').click(function() {
    let product_detail_id = $('.color-product .color-inner.active').attr('product-id');
    var qty = $('.form-payment input.qty').val();
    
    // Capture the selected color and size (if available)
    var size = $('.color-product .size-inner.active').attr('product-size-value');
    if(size) {
        product_detail_id = $('.color-product .size-inner.active').attr('product-id');
    }

    // Prepare the data to send
    var data = {
        id: product_detail_id,
        qty,
    };
    
    var url = $(this).attr('data-url');
    
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'JSON',
        success: function(data) {
            $('#cart-sidebar').remove();
            $('.mini-cart .top-cart-content').append(htmlCart(data.response, data.url));
            $('.support-cart .count_item_pr').empty();
            $('.support-cart .count_item_pr').append(data.response.totalQty);
            Swal.fire({
                title: 'Thành Công',
                text: data.msg,
                type: 'success'
            })
        },
        error: function(data) {
            var errors = data.responseJSON;
            Swal.fire({
                title: 'Thất bại',
                text: errors.msg,
                type: 'error'
            })
        }
    });
});

  $(document).on('error', 'img', function() {
    $(this).attr('src', '/images/no-image.png');
  });
});

function displayGallery(key) {
  console.log(key)
    var slider = $('#imageGallery-' + key).lightSlider({
        gallery: true,
        item: 1,
        loop: true,
        thumbItem: 5,
        slideMargin: 0,
        enableDrag: true,
        controls: false,
        slideMargin: 1,
        currentPagerPosition: 'middle',
        onSliderLoad: function(el) {
            $(window).resize();
            el.lightGallery({
                selector: '#imageGallery-' + key + ' .lslide',
            });
        },
        onBeforeSlide: function (el) {
            $('body').addClass('lg-on');
        },
        onAfterSlide: function (el) {
            $('body').removeClass('lg-on');
        }
    });
    return slider;
}
function scrollToxx() {
  $('html, body').animate({ scrollTop: $('.tab-description').offset().top }, 'slow');
  $('.tab-header .nav-tab-custom>li.active').removeClass('active');
  $('.tab-header .nav-tab-custom>li.active, .tab-content>div.active').removeClass('active in');
  $('.tab-header .nav-tab-custom>li:nth-child(2)').addClass('active');
  $('.tab-header .nav-tab-custom>li:nth-child(2), #vote').addClass('active in');
}
function minusInput() {
  var result = document.getElementById('qty');
  var qty = parseInt(result.value);
  var min = parseInt(result.min);
  if(!isNaN(qty) & qty > min )
    result.value--;
  if(result.value == 0)
    $('.form-payment .row>div>button').prop('disabled', true);
  return false;
}
function plusInput() {
  var result = document.getElementById('qty');
  var qty = parseInt(result.value);
  var max = parseInt(result.max);
  if(!isNaN(qty) & qty < max)
    result.value++;
  if(result.value > 0)
    $('.form-payment .row>div>button').prop('disabled', false);
  return false;
}
$(document).ready(function(){
  $('.form-payment button[type="submit"]').click(function () {
    var qty = $('#qty').val();
    var id = $('.select-color .color-inner.active').attr('product-id');
    var input_1 = $("<input>").attr("type", "hidden").attr("name", "type").val('buy_now');
    var input_2 = $("<input>").attr("type", "hidden").attr("name", "id").val(id);
    var input_3 = $("<input>").attr("type", "hidden").attr("name", "qty").val(qty);
    $('.form-payment>form').append(input_1);
    $('.form-payment>form').append(input_2);
    $('.form-payment>form').append(input_3);
  });
});
