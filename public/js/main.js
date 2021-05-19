
const menuItems = ['menu_home_page', 'menu_categories_page', 'menu_cart_page', 'menu_account_page'];
// const BASE_URI = 'http://localhost:8000/';
const BASE_URI = 'http://206.189.195.11/';
const STORED_AUTODETECTED_ADDRESS = 'STORED_AUTODETECTED_ADDRESS';
const CARTED_PRODUCTS = 'CARTED_PRODUCTS';
const SHOPPING_FOR_DATE = 'SHOPPING_FOR_DATE';

let api_token = null;

(function() {
    $('body').on('click', (event) => {
        switch(event.target.id) {
            case 'email_reg_link':
                $('#email_reg_link').addClass('active_link');
                $('#email_reg_link').removeClass('regular_link');
                $('#phone_reg_link').addClass('regular_link');
                $('#phone_reg_link').removeClass('active_link');

                $('#email_reg_form').addClass('d-block');
                $('#phone_reg_form').addClass('d-none');
                $('#email_reg_form').removeClass('d-none');
                $('#phone_reg_form').removeClass('d-block');
                break;
            case 'phone_reg_link':
                $('#phone_reg_link').addClass('active_link');
                $('#phone_reg_link').removeClass('regular_link');
                $('#email_reg_link').addClass('regular_link');
                $('#email_reg_link').removeClass('active_link');

                $('#phone_reg_form').addClass('d-block');
                $('#phone_reg_form').removeClass('d-none');
                $('#email_reg_form').addClass('d-none');
                $('#email_reg_form').removeClass('d-block');
                break;
            case 'menu_home_page':
                clearMenuItems();
                $('#menu_home_page').addClass('menu_selected_item');
                break;
            case 'menu_categories_page':
                clearMenuItems();
                $('#menu_categories_page').addClass('menu_selected_item');
                break;
            case 'menu_cart_page':
                clearMenuItems();
                $('#menu_cart_page').addClass('menu_selected_item');

                let itemIds = '';
                for (const [key, value] of Object.entries(cartedItems)) {
                    itemIds += `${key}-${value}:::`;
                }

                const cartUri = `${BASE_URI}cart?products=${itemIds}`;

                window.location.href = cartUri;
                break;
            // case 'menu_account_page':
            //     clearMenuItems();
            //     $('#menu_account_page').addClass('menu_selected_item');
            //     break;
            case 'index_items_new':
                clearTabLinks();
                hideItemTabs();
                $('#carouselForNewItems').addClass('visible_element');
                $('#index_items_new').addClass('selected_link_special');
                break;
            case 'index_items_best_sellers':
                clearTabLinks();
                hideItemTabs();
                $('#carouselForTopItems').addClass('visible_element');
                $('#index_items_best_sellers').addClass('selected_link_special');
                break;
            case 'index_items_hits':
                clearTabLinks();
                hideItemTabs();
                $('#carouselForHitItems').addClass('visible_element');
                $('#index_items_hits').addClass('selected_link_special');
                break;
            case 'header_search_icon':
                const searchQuery = prompt('Search term');
                console.log(searchQuery);
                break;
            case 'decrement_quantity':
                const itemId = event.target.dataset.id;
                const currentVal = $(`#quantity_${itemId}`).val();
                let updatedVal = null;
                if (parseInt(currentVal) - 1 >= 0) {
                    updatedVal = parseInt(currentVal) - 1;
                } else {
                    updatedVal = 0;
                }
                $(`#quantity_${itemId}`).val(updatedVal);

                if (updatedVal == 0) {
                    delete cartedItems[itemId];
                } else {
                    cartedItems[itemId] = updatedVal;
                }

                updatedCartedItemsCount();
                break;
            case 'increment_quantity':
                const itemId2 = event.target.dataset.id;
                const currentVal2 = $(`#quantity_${itemId2}`).val();
                let updatedVal2 = parseInt(currentVal2) + 1;
                
                $(`#quantity_${itemId2}`).val(updatedVal2);

                cartedItems[itemId2] = updatedVal2;

                updatedCartedItemsCount();
                break;
            case 'login_with_phone':
                event.preventDefault();

                const btnText = $('#login_with_phone').text().trim();

                const phone = $('#phone').val();
                const code = $('#sms_code').val();

                if (!phone)
                {
                    alert('Phone is mandatory');
                    return;
                }

                if (btnText == 'Login with Phone' && !code)
                {
                    alert('SMS code is mandatory');
                    return;
                }

                api_token = $('input[name=_token]').val();

                const payload = {
                    _token: api_token,
                    phone
                };

                if (btnText == 'Login with Phone')
                {
                    payload['code'] = code;
                }

                let uri;
                if (btnText == 'Request code') {
                    uri = `${BASE_URI}verify/start`;
                } else {
                    uri = `${BASE_URI}verify/code`;
                }
                
                axios.post(uri, payload, {})
                    .then(res => {
                        if (res.data.status == 200) {
                            if (btnText == 'Request code') {
                                alert('You\'ll receive code with sms soon');
                                $('#login_with_phone').text('Login with Phone');
                            } else {
                                window.location.href = (location.origin + '/home');
                            }
                            
                        } else {
                            alert(res.data.msg);
                        }
                    })
                    .catch(err => {
                        alert(err);
                    });

                break;
            case 'autolocate_icon':
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((position) => {
                        
                        const geocoder = new google.maps.Geocoder();
                        const latlng = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };

                        geocoder.geocode({ location: latlng }, (results, status) => {
                            if (status === "OK") {
                                // console.log('results: ' + JSON.stringify(results[0].formatted_address));
                                if (results[0]) {
                                    $('#zip').val(results[0].formatted_address);
                                } else {
                                    alert("No results found for address autodetection");
                                }
                            } else {
                              alert("Can't autolocate your place due to: " + status);
                            }
                        });

                    });
                } else {
                    alert('Auto-location not available!');
                }
                break;
            case 'continue_with_autodetected_address':
                event.preventDefault();

                const address = $('#zip').val();
                api_token = $('input[name=_token]').val();

                if (!address) {
                    alert("Can't continue without address or zip submitted");
                    return;
                }

                localStorage.setItem(STORED_AUTODETECTED_ADDRESS, address);

                const payload2 = {
                    _token: api_token
                };

                const uri2 = `${BASE_URI}login/guest`;
                
                axios.post(uri2, payload2, {})
                    .then(res => {
                        if (res.data.status == 200) {
                            window.location.href = (location.origin + '/home');
                        } else {
                            alert(res.data.msg);
                        }
                    })
                    .catch(err => {
                        alert(err);
                    });

                break;
            case 'order_checkout':
                api_token = $('input[name=_token]').val();

                let itemIds2 = '';
                for (const [key, value] of Object.entries(cartedItems)) {
                    itemIds2 += `${key}-${value}:::`;
                }

                if (!itemIds2) {
                    alert('No carted items');
                    return;
                }

                const payload3 = {
                    _token: api_token,
                    products: itemIds2,
                    shopping_date: $('#delivery_date_input').val(),
                };

                const deliveryAddress = localStorage.getItem(STORED_AUTODETECTED_ADDRESS);
                let deliveryPhone = null;
                if (deliveryAddress) {
                    payload3['delivery_address'] = deliveryAddress;

                    deliveryPhone = prompt('Enter your phone number, please');
                    if (!deliveryPhone) {
                        return;
                    }

                    payload3['delivery_phone'] = deliveryPhone;
                }

                const storeOrderUri = `${BASE_URI}order`;

                axios.post(storeOrderUri, payload3, {})
                    .then(res => {
                        if (res.data.status == 201) {
                            localStorage.removeItem(SHOPPING_FOR_DATE);
                            localStorage.removeItem(CARTED_PRODUCTS);

                            if (deliveryAddress) {
                                window.location.href = `/account?address=${deliveryAddress}`;
                            } else {
                                window.location.href = '/account';
                            }

                        } else if (res.data.status == 401) {
                            window.location.href = '/login';
                        } else {
                            alert(res.data.msg);
                        }
                    })
                    .catch(err => {
                        console.log(err);
                        alert('Error posting order', err);
                    });

                break;
            case 'menu_account_page':
            case 'apply_filters_id':
                const statusFilter = $('#status_selector_id').val();
                const orderIdFilter = $('#searched_order_id').val() ? $('#searched_order_id').val() : 'null';

                const deliveryAddress2 = localStorage.getItem(STORED_AUTODETECTED_ADDRESS);
                
                let queryString = `/account?`;
                if (statusFilter) {
                    queryString += `status=${statusFilter}`;
                }
                if (orderIdFilter != 'null') {
                    queryString += `&orderId=${orderIdFilter}`;
                }
                if (deliveryAddress2) {
                    queryString += `&address=${deliveryAddress2}`;
                }

                window.location.href = queryString;

                break;
            case 'logout_id':
                api_token = $('input[name=_token]').val();

                const payload4 = {
                    _token: api_token
                };

                axios.post('/logout', payload4, {})
                    .then(res => {
                        localStorage.removeItem(SHOPPING_FOR_DATE);
                        localStorage.removeItem(STORED_AUTODETECTED_ADDRESS);
                        localStorage.removeItem(CARTED_PRODUCTS);

                        window.location.href = '/';
                    })
                    .catch(err => {
                        alert('Could not log out');
                    });
                break;
            case 'edit_user':
                const userId = event.target.getAttribute('data-id');
                const name = $(`#user_name_${userId}`).text();
                const email = $(`#user_email_${userId}`).text();
                const phone2 = $(`#user_phone_${userId}`).text();
                const role = $(`#user_role_${userId}`).text();

                $(`#user_id`).val(userId);
                $(`#user_email`).val(email);
                $(`#user_name`).val(name);
                $(`#user_phone`).val(phone2);
                $(`#user_role`).val(role);

                $(`#users_edit_dialog`).modal('show');

                break;
            case 'save_edited_user':
                const editedId = $(`#user_id`).val();
                const editedEmail = $(`#user_email`).val();
                const editedName = $(`#user_name`).val();
                const editedPhone = $(`#user_phone`).val();
                const editedRole = $(`#user_role`).val();

                api_token = $('input[name=_token]').val();

                const payload7 = {
                    editedId,
                    editedEmail,
                    editedName,
                    editedPhone,
                    editedRole,
                    _token: api_token,
                };

                const uri3 = `${BASE_URI}admin/users`;
                axios.post(uri3, payload7, {})
                    .then(res => {
                        if (res.data.status == 200) {
                            window.location.reload();
                        } else {
                            alert(res.data.msg);
                        }
                    })
                    .catch(err => {
                        console.log(err);
                        alert('Error updating user', err);
                    });

                $(`#users_edit_dialog`).modal('hide');
                break;
            case 'edit_order':
                const orderId = event.target.getAttribute('data-id');
                const orderedForDate = $(`#order_ordered_for_date_${orderId}`).text();
                const totalPrice = $(`#order_total_price_${orderId}`).text().substring(1);
                const orderStatus = $(`#order_status_${orderId}`).text();
                const orderDeliveryPhone = $(`#order_delivery_phone_${orderId}`).text();

                $(`#order_id`).val(orderId);
                $(`#order_ordered_for_date`).val(orderedForDate);
                $(`#order_price`).val(totalPrice);
                $(`#order_phone`).val(orderDeliveryPhone);
                $(`#order_status`).val(orderStatus);

                $(`#orders_edit_dialog`).modal('show');

                break;
            case 'save_edited_order':
                event.preventDefault();

                const editedOrderId = $(`#order_id`).val();
                const editedOrderOrderedForDate = $(`#order_ordered_for_date`).val();
                const editedOrderPrice = $(`#order_price`).val();
                const editedOrderPhone = $(`#order_phone`).val();
                const editedOrderStatus = $(`#order_status`).val();

                api_token = $('input[name=_token]').val();

                const payload8 = {
                    editedOrderId,
                    editedOrderOrderedForDate,
                    editedOrderPrice,
                    editedOrderPhone,
                    editedOrderStatus,
                    _token: api_token,
                };

                const uri5 = `${BASE_URI}admin/orders`;
                axios.post(uri5, payload8, {})
                    .then(res => {
                        if (res.data.status == 200) {
                            window.location.reload();
                        } else {
                            alert(res.data.msg);
                        }
                    })
                    .catch(err => {
                        console.log(err);
                        alert('Error updating order', err);
                    });

                $(`#orders_edit_dialog`).modal('hide');
                break;
            case 'edit_product':
                const productId = event.target.getAttribute('data-id');
                const productName = $(`#product_name_${productId}`).text();
                const productPrice = $(`#product_price_${productId}`).text().substring(1);
                const productCount = $(`#product_count_${productId}`).text();
                const productCategory = $(`#product_category_${productId}`).val();

                $(`#product_id`).val(productId);
                $(`#product_name`).val(productName);
                $(`#product_price`).val(productPrice);
                $(`#product_count`).val(productCount);

                if (productCategory) {
                    $(`#product_category`).val(productCategory);
                } else {
                    $(`#product_category`).val('-1');
                }

                $(`#products_edit_dialog`).modal('show');

                break;
            case 'save_edited_product':
                event.preventDefault();

                const editedProductId = $(`#product_id`).val();
                const editedProductName = $(`#product_name`).val();
                const editedProductPrice = $(`#product_price`).val();
                const editedProductCount = $(`#product_count`).val();
                const editedProductCategory = $(`#product_category`).val();

                api_token = $('input[name=_token]').val();

                const payload9 = {
                    editedProductId,
                    editedProductName,
                    editedProductPrice,
                    editedProductCount,
                    editedProductCategory,
                    _token: api_token,
                };

                const uri6 = `${BASE_URI}admin/products`;
                axios.post(uri6, payload9, {})
                    .then(res => {
                        if (res.data.status == 200) {
                            window.location.reload();
                        } else {
                            alert(res.data.msg);
                        }
                    })
                    .catch(err => {
                        console.log(err);
                        alert('Error updating product', err);
                    });

                $(`#products_edit_dialog`).modal('hide');
                break;
            case 'upload_product_image':
                const editingProductId = event.target.getAttribute('data-id');

                $(`#editing_product_image_product_id`).val(editingProductId);

                $(`#product_image_edit_dialog`).modal('show');
                break;
            case 'update_account_info':
                const editedAccountName = $('#account_name').val();
                const editedAccountSurname = $('#account_surname').val();
                const editedAccountPhone = $('#account_telephone').val();

                const fullname = `${editedAccountName} ${editedAccountSurname}`.trim();

                api_token = $('input[name=_token]').val();

                const payload10 = {
                    fullname,
                    editedAccountPhone,
                    _token: api_token,
                };

                const uri7 = `${BASE_URI}account`;
                
                axios.post(uri7, payload10, {})
                    .then(res => {
                        if (res.data.status == 200) {
                            window.location.reload();
                        } else {
                            alert(res.data.msg);
                        }
                    })
                    .catch(err => {
                        console.log(err);
                        alert('Error updating user info', err);
                    });
                break;
            default:
                break;
        }
    });

    // itemId => cartedCount
    let cartedItems = {};
    function updatedCartedItemsCount() {
        let count = 0;

        for (const [key, value] of Object.entries(cartedItems)) {
            count += parseInt(value);
        }

        if (count > 0) {
            $('#menu_item_capture_id').text(`Cart(${count})`);
            $('#menu_item_capture_id').css('color', 'red');

            localStorage.setItem(CARTED_PRODUCTS, JSON.stringify(cartedItems));
        } else {
            $('#menu_item_capture_id').text(`Cart`);
            $('#menu_item_capture_id').css('color', '');

            localStorage.removeItem(CARTED_PRODUCTS);
        }

        $('#total_count').text(count);

    }

    $('#delivery_date_input').change(e => {
        localStorage.setItem(SHOPPING_FOR_DATE, $('#delivery_date_input').val());
    });

    const shoppingDate = localStorage.getItem(SHOPPING_FOR_DATE);
    if (shoppingDate) {
        $('#delivery_date_input').val(shoppingDate);
    }

    cartedItems = localStorage.getItem(CARTED_PRODUCTS) ? JSON.parse(localStorage.getItem(CARTED_PRODUCTS)) : {};
    if (cartedItems) {
        let count = 0;
        for (const [key, value] of Object.entries(cartedItems)) {
            count += parseInt(value);

            $(`#quantity_${key}`).val(value);
        }

        if (count > 0) {
            $('#menu_item_capture_id').text(`Cart(${count})`);
            $('#menu_item_capture_id').css('color', 'red');
        }

        $('#total_count').text(count);
    }

    if (document.getElementById('categories_splide_main')) {
        new Splide( '#categories_splide_main', {
            type   : 'loop',
            perPage: 3,
            perMove: 1,
            autoplay: true,
        } ).mount();
    }

    if (document.getElementById('categories_splide_categories')) {
        new Splide( '#categories_splide_categories', {
            type   : 'loop',
            perPage: 4,
            perMove: 1,
            autoplay: true,
        } ).mount();
    }

    highlightMenuItem();

})();

function highlightMenuItem() {
    const pathname = window.location.pathname;
    if (pathname.startsWith('/cart')) {
        $('#menu_cart_page').addClass('menu_selected_item');
    } else if (pathname.startsWith('/categories')) {
        $('#menu_categories_page').addClass('menu_selected_item');
    } else if (pathname.startsWith('/home')) {
        $('#menu_home_page').addClass('menu_selected_item');
    } else if (pathname.startsWith('/account')) {
        $('#menu_account_page').addClass('menu_selected_item');
    }
}

function hideItemTabs() {
    ['carouselForNewItems', 'carouselForTopItems', 'carouselForHitItems'].forEach(item => {
        $(`#${item}`).removeClass('visible_element');
    });
}

function clearTabLinks() {
    ['index_items_new', 'index_items_best_sellers', 'index_items_hits'].forEach(item => {
        $(`#${item}`).removeClass('selected_link_special');
    });
}

function clearMenuItems() {
    menuItems.forEach(item => {
        $(`#${item}`).removeClass('menu_selected_item');
    });
}
