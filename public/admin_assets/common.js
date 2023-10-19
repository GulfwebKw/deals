$(document).ready(function () {



    var BASE_URL = '';



    setTimeout(function () {
        $(".alert-success").fadeToggle();
        $(".alert-danger").fadeToggle();
    }, 5000);



    //reset order date range
    $(".resetOrderDateRange").click(function () {
        $.ajax({
            type: "POST",
            url: BASE_URL + "/gwc/orders/reset-date-range",
            dataType: "json",
            cache: false,
            processData: false,
            success: function () {
                window.location.reload();
            },
            error: function () {
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
            }
        });
    });



    //reset transaction date range
    $(".resetTransactionDateRange").click(function () {
        $.ajax({
            type: "POST",
            url: BASE_URL + "/gwc/transactions/reset-date-range",
            dataType: "json",
            cache: false,
            processData: false,
            success: function () {
                window.location.reload();
            },
            error: function () {
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
            }
        });
    });



    //filter orders by date
    $("#filterOrdersByDate").click(function () {
        var val = $("#kt_daterangepicker_range").val();
        $.ajax({
            type: "POST",
            url: BASE_URL + "/gwc/orders/ajax",
            data: "order_dates=" + val,
            dataType: "json",
            cache: false,
            processData: false,
            success: function () {
                window.location.reload();
            },
            error: function () {
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
            }
        });
    });



    //filter transactions by date
    $("#filterTransactionsByDate").click(function () {
        var val = $("#kt_daterangepicker_range").val();
        $.ajax({
            type: "POST",
            url: BASE_URL + "/gwc/transactions/ajax",
            data: "payment_dates=" + val,
            dataType: "json",
            cache: false,
            processData: false,
            success: function () {
                window.location.reload();
            },
            error: function () {
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
            }
        });
    });



    //filter orders by status
    $(".orderstatus").click(function () {
        var val = $(this).attr("id");
        $.ajax({
            type: "POST",
            url: BASE_URL + "/gwc/orders/ajax",
            data: "order_status=" + val,
            dataType: "json",
            cache: false,
            processData: false,
            success: function () {
                window.location.reload();
            },
            error: function () {
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
            }
        });
    });



    //filter transaction by status
    $(".paymentstatus").click(function () {
        var val = $(this).attr("id");
        $.ajax({
            type: "POST",
            url: BASE_URL + "/gwc/transactions/ajax",
            data: "payment_status=" + val,
            dataType: "json",
            cache: false,
            processData: false,
            success: function () {
                window.location.reload();
            },
            error: function () {
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
            }
        });
    });



    //filter orders by payment status
    $(".paystatus").click(function () {
        var val = $(this).attr("id");
        $.ajax({
            type: "POST",
            url: BASE_URL + "/gwc/orders/ajax",
            data: "pay_status=" + val,
            dataType: "json",
            cache: false,
            processData: false,
            success: function () {
                window.location.reload();
            },
            error: function () {
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
            }
        });
    });

















    $("#order_vendors").change(function () {
        var vendorid = $(this).val();
        if (vendorid !== "") {
            window.location = BASE_URL + "/gwc/vendors/orders/" + vendorid;
        }
    });



    $("#product_vendors").change(function () {
        var vendorid = $(this).val();
        if (vendorid !== "") {
            window.location = BASE_URL + "/gwc/vendors/products/" + vendorid;
        }
    });



    $(".chooseVendor").change(function () {
        var id = $(this).attr("id");
        var vendor_id = $(this).val();
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/products/choosevendor/ajax",
            data: "vendor_id=" + vendor_id + "&id=" + id,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                //notification start
                var notify = $.notify({message: msg.message});
                notify.update('type', 'success');
                //notification end
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



    $(".viewcustomerorder").click(function () {
        var val = $(this).attr('id');
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/storetocookie/ajax",
            data: "key=order_customers&val=" + val,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function () {
                window.location = BASE_URL + '/gwc/orders';
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



    $(".viewcustomerwish").click(function () {
        var val = $(this).attr('id');
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/storetocookie/ajax",
            data: "key=wish_customers&val=" + val,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function () {
                window.location = BASE_URL + '/gwc/customers/wishitems';
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



	//reset product filtration
    $(".resetProductFilters").click(function () {
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/products/reset/ajax",
            data: "s=1",
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function () {
                window.location.reload();
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



	//filter items via section
    $(".filterByOutofStock").click(function () {
        var val = $(this).attr("id");
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/storetocookie/ajax",
            data: "key=item_outofstock&val=" + val,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function () {
                window.location.reload();
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



    $(".filterByStatus").click(function () {
        var val = $(this).attr("id");
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/storetocookie/ajax",
            data: "key=item_status&val=" + val,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function () {
                window.location.reload();
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



    $(".filterBySections").click(function () {
        var val = $(this).attr("id");
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/storetocookie/ajax",
            data: "key=item_sections&val=" + val,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function () {
                window.location.reload();
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



    $(".filterBySectionsDirect").click(function () {
        var val = $(this).attr("id");
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/storetocookie/ajax",
            data: "key=item_sections&val=" + val,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function () {
                window.location = BASE_URL + '/gwc/products';
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



	//wish items
    $("#wish_customers").change(function () {
        var val = $(this).val();
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/storetocookie/ajax",
            data: "key=wish_customers&val=" + val,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function () {
                window.location.reload();
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



	//store customer id to cookie
    $("#order_customers").change(function () {
        var val = $(this).val();
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/storetocookie/ajax",
            data: "key=order_customers&val=" + val,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function () {
                window.location.reload();
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



	//update single quantity
    $(".updatesingleqty").click(function () {

        var id = $(this).attr("id");
        $("#qty_gif_" + id).show();
        var quantity = $("#quantity_" + id).val();
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/products/editsinglequantity/ajax",
            data: "id=" + id + "&quantity=" + quantity,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                $("#qty_gif_" + id).hide();
				var notify = $.notify({message: msg.message});
                if (msg.status === 200) {
                    $("#q-" + id).html(quantity);
                    $("#qtyedit-" + id).html(msg.message);
                    notify.update('type', 'success');
                } else {
                    notify.update('type', 'danger');
                }
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
                $("#qty_gif_" + id).hide();
            }
        });
    });



	//delete child option
    $(".deleteChildOption").click(function () {
        var id = $(this).attr("id");
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/products/editoptions/delete/ajax",
            data: "id=" + id,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
				var notify = $.notify({message: msg.message});
                if (msg.status === 200) {
                    $("#cdiv-" + id).hide();
                    //notification start
                    notify.update('type', 'success');
                    //notification end
                } else {
                    //notification start
                    notify.update('type', 'danger');
                    //notification end
                }
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



	//change order status
    $(".changeorderstatus").click(function () {
        var id = $(this).attr("id");
        var order_status = $("#order_status" + id).val();
        var pay_status = $("#pay_status" + id).val();
        var extra_comment = $("#extra_comment" + id).val();
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/orders/status/ajax",
            data: "id=" + id + "&order_status=" + order_status + "&pay_status=" + pay_status + "&extra_comment=" + extra_comment,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                $("#OrderStatusMsg" + id).html(msg.message);
				var notify = $.notify({message: msg.message});
                if (msg.status === 200) {
                    //notification start
                    notify.update('type', 'success');
                    //notification end
                } else {
                    //notification start
                    notify.update('type', 'danger');
                    //notification end
                }
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



    $("#filterBydatesPayent").click(function () {
        var val = $("#kt_daterangepicker_range").val();
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/orders/ajax",
            data: "payment_dates=" + val,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function () {
                window.location.reload();
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



    $(".change_status").change(function () {
        var keys = $(this).attr("id");
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/" + keys + "/ajax/" + id,
            data: "id=" + id,
            success: function (msg) {
                console.log(msg)
                //notification start
                var notify = $.notify({message: msg.message});
                notify.update('type', 'success');

                setTimeout(()=>{
                if (msg.w && msg.w.length>0){
                    for (let w of msg.w){
                var n = $.notify({message: w});
                notify.update('type', 'warning');
                    }
                }
                },1000)
                //notification end
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });

    $(".wishlistt").change(function () {
        var keys = $(this).attr("data-path");
        var user = $(this).attr("data-id");
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/" + keys + "/ajax/" + user,
            data: "id=" + id,
            success: function (msg) {
                //notification start
                var notify = $.notify({message: msg});
                notify.update('type', 'success');
                //notification end
            },
            error: function () {
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });


    $(".change_newsletter").change(function () {
        var keys = $(this).attr("id");
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/" + keys + "/newsletter/" + id,
            data: "id=" + id,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                //notification start
                var notify = $.notify({message: msg.message});
                notify.update('type', 'success');
                //notification end
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



	//update gallery details
    $(".updateGalleryDetails").click(function () {
        var id = $(this).attr("id");
        var title_en = $("#atitle_en_" + id).val();
        var title_ar = $("#atitle_ar_" + id).val();
        var display_order = $("#display_order_" + id).val();
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/productGallery/" + id + "/" + title_en + "/" + title_ar + "/" + display_order,
            data: "id=" + id,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                //notification start
                var notify = $.notify({message: msg.message});
                notify.update('type', 'success');
                //notification end
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



    $(".updateAttributeDetails").click(function () {
        var id = $(this).attr("id");
        var color = $("#color_" + id).val();
        var size = $("#size_" + id).val();
        var quantity = $("#quantity_" + id).val();
        var retail_price = $("#retail_price_" + id).val();
        var old_price = $("#old_price_" + id).val();
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/productAttribute/" + id + "/" + color + "/" + size + "/" + quantity + "/" + retail_price + "/" + old_price,
            data: "id=" + id,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                //notification start
                var notify = $.notify({message: msg.message});
                notify.update('type', 'success');
                //notification end
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



    $(".updateCategoryDetails").click(function () {
        var id = $(this).attr("id");
        var category = $("#category-" + id).val();

        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/productCategory/" + id + "/" + category,
            data: "id=" + id,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                //notification start
                var notify = $.notify({message: msg.message});
                notify.update('type', 'success');
                //notification end
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



	//choose default address
    $(".chooseDefault").click(function () {
        var id = $(this).attr("id");
        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/customers/addressDefault/ajax/" + id,
            data: "id=" + id,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                //notification start
                var notify = $.notify({message: msg.message});
                notify.update('type', 'success');
                //notification end
                window.location.reload();
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



    //load child
    $('#country').on('change', function (e) {
        //console.log(e);
        var id = e.target.value;
        //console.log(id);
        //ajax
        $.get(BASE_URL + '/gwc/country/ajax-state/' + id, function (data) {
            //success data
            //console.log(data);
            var state = $('#state');
            state.empty();
            $.each(data, function (key, val) {
                // var option = $('<option/>', {id: val['id'], value: val['name_en']});
                state.append('<option value ="' + val['id'] + '">' + val['name_en'] + '</option>');
            });
        });
    });



    $('#state').on('change', function (e) {
        //console.log(e);
        var id = e.target.value;
        //console.log(id);
        //ajax
        $.get(BASE_URL + '/gwc/state/ajax-area/' + id, function (data) {
            //success data
            //console.log(data);
            var area = $('#area');
            area.empty();
            $.each(data, function (key, val) {
                // var option = $('<option/>', {id: val['id'], value: val['name_en']});
                area.append('<option value ="' + val['id'] + '">' + val['name_en'] + '</option>');
            });
        });
    });



    //change asorting
    $(".update_asorting").change(function () {
        var keys = $(this).attr("alt");
        var id = $(this).attr("id");
        var val = $(this).val();

        $.ajax({
            type: "GET",
            url: BASE_URL + "/gwc/" + keys + "/image/ajaxAsorting/" + id,
            data: "val=" + val,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                //notification start
                var notify = $.notify({message: msg.message});
                notify.update('type', 'success');
                //notification end
            },
            error: function () {
                //notification start
                var notify = $.notify({message: 'Error occurred while processing'});
                notify.update('type', 'danger');
                //notification end
            }
        });
    });



});
