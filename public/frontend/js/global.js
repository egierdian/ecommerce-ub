$(document).ready(function() {
  $('.btn-delete-cart').click(function (e) {
    e.preventDefault();
    let cartId = $(this).data('id');
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $('.section-message').html('')
    $.ajax({
        url: '/cart/delete/' + cartId,
        type: 'POST',
        data: {
          _token: csrfToken
        },
        success: function (response) {
          let msgAlert = 'danger'
          if(response.status) {
            $('#cart-item-' + cartId).remove()
            $('.cart-total').text(`Rp ${response.total}`)
            $('.count-cart').text(`${response.count}`)
            msgAlert = 'success'
          } else {
          }
          $('.section-message').append(`<div class="alert alert-${msgAlert} d-flex justify-content-between align-items-center" id="msgCartError" style="display: none;">
                        <span class="message">${response.message}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`)
        }
    });
  });

    
  $('.btn-wishlist').click(function (e) {
    e.preventDefault();
    let productId = $(this).data('id');
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // let btn = $(this);
    let btn = $('.btn-wishlist[data-id="' + productId + '"]'); 
    $.ajax({
        url: '/wishlist/' + productId,
        type: 'POST',
        data: {
          _token: csrfToken
        },
        success: function (response) {
          if(response.status){
            if (btn.hasClass("active")) {
              
              btn.removeClass("active");
              btn.html(`
                    <svg width="14" height="14">
                      <use xlink:href="#heart"></use>
                    </svg>
              `)
            } else {
              btn.addClass("active");
              btn.html(`
                    <svg width="14" height="14">
                      <use xlink:href="#trash"></use>
                    </svg>
              `);
            }
          }
        }
    });
  });

  $('.btn-update-cart').click(function (e) {
    e.preventDefault();
    let cartId = $(this).data('id');
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $('.section-message').html('')
    $.ajax({
        url: '/cart/update/' + cartId,
        type: 'POST',
        data: {
          _token: csrfToken,
          quantity: $(`.item-quantity-cart-${cartId} [name=quantityCart]`).val()
        },
        success: function (response) {
          let msgAlert = 'danger'
          if(response.status) {
            $('.cart-total').text(`Rp ${response.total}`)
            $('.count-cart').text(`${response.count}`)
            $(`#item-quantity-cart-${cartId} [name=quantityCart]`).val(response.quantity)
            msgAlert = 'success'
          } else {
          }
          $('.section-message').append(`<div class="alert alert-${msgAlert} d-flex justify-content-between align-items-center" id="msgCartError" style="display: none;">
                        <span class="message">${response.message}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`)
        }
    });
  });
})