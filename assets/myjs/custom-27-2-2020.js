var billtype = $('#billtype').val();
var d_csrf=crsf_token+'='+crsf_hash;
$('#addproduct').on('click', function () {


    var cvalue = parseInt($('#ganak').val())+1;
    var nxt=parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;


//product row
    var data = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td><td> <input type="text" class="form-control vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
    //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith='+request.term+'&type=product_list&row_num='+row+'&wid='+$("#s_warehouses option:selected").val()+'&'+d_csrf,
                success: function (data) {
                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                var t_r = $("#taxformat option:selected").attr('data-trate');
            }
               var discount = ui.item.data[4];
          var custom_discount=$('#custom_discount').val();
          if(custom_discount>0) discount=deciFormat(custom_discount);

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(ui.item.data[1]);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            $('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            rowTotal(cvalue);
            billUpyog();


        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });


    var sideh2 = document.getElementById('rough').scrollHeight;
    var opx3 = sideh2 + 50;
    document.getElementById('rough').style.height = opx3 + "px";
});

//caculations
var precentCalc = function (total, percentageVal) {
    return (total / 100) * percentageVal;
};
//format
var deciFormat = function (minput) {
    if(!minput) minput=0;
    return parseFloat(minput).toFixed(2);
};
var formInputGet = function (iname, inumber) {
    var inputId;
    inputId = iname + '-' + inumber;
    var inputValue = $(inputId).val();

    if (inputValue == '') {

        return 0;
    } else {
        return inputValue;
    }
};

//ship calculation
var coupon = function () {
    var cp = 0;
    if ($('#coupon_amount').val()) {
        cp = parseFloat($('#coupon_amount').val());
    }
    return cp;
 };
var shipTot = function () {
  var ship_val = +$('.shipVal').val();
   var ship=0;
    var ship_p=0;
    if(ship_val == '') {
        $('.shipVal').val(0);

    }
    else {



         if ($("#taxformat option:selected").attr('data-trate')) {

                  var ship_rate =$("#taxformat option:selected").attr('data-trate');
            }
            else{
                    var ship_rate = +$('#ship_rate').val();
         }

       var tax_status = $("#ship_taxtype").val();



             if(tax_status == 'excl'){
                 ship_p=(ship_val*ship_rate)/100;
                 ship_val=ship_val+ship_p;
             }
             else if(tax_status == 'incl'){
                  ship_p=(+ship_val * +ship_rate) / (100 + +ship_rate);
             }






    }
    $('#ship_tax').val(deciFormat(ship_p));
    $('#ship_final').html(deciFormat(ship_p));
    return deciFormat(+ship_val);
};
//product total
var samanYog = function () {
    var itempriceList = [];
    var idList = [];
    var r = 0;
    $('.ttInput').each(function () {
        var vv = $(this).val();
        var vid = $(this).attr('id');
        vid = vid.split("-");
        if (vv === '') {
            vv = 0;
        }

        itempriceList.push(vv);
        idList.push(vid[1]);
        r++;
    });
    var sum = 0;
    var taxc = 0;
    var discs = 0;
    var ganak = parseInt($("#ganak").val()) + 1;

    for (var z = 0; z < idList.length; z++) {
        var x = idList[z];
        if (parseFloat(itempriceList[z]) > 0) {
            sum += parseFloat(itempriceList[z]);
        }
        if (parseFloat($("#taxa-" + x).val()) > 0) {
            taxc += parseFloat($("#taxa-" + x).val());
        }
        if (parseFloat($("#disca-" + x).val()) > 0) {
            discs += parseFloat($("#disca-" + x).val());
        }
    }
    discs = deciFormat(discs);
    taxc = deciFormat(taxc);
    sum = deciFormat(sum);
    $("#discs").html(discs);
    $("#taxr").html(taxc);
    return sum;

};

//actions
var deleteRow = function (num) {
    var prodTotalID;
    var prodttl;
    var subttl;
    var totalSubVal;
    var totalBillVal;
    var totalSelector = $("#subttlform");
    prodTotalID = "#total-" + num;
    prodttl = $(prodTotalID).val();
    subttl = totalSelector.val();
    totalSubVal = deciFormat(subttl - prodttl);
    totalSelector.val(totalSubVal);
    $("#subttlid").html(totalSubVal);
    totalBillVal = totalSubVal + shipTot - coupon;
    //final total
   var clean=deciFormat(totalBillVal);
    $("#mahayog").html(clean);
    $("#invoiceyoghtml").val(clean);
    $("#bigtotal").html(clean);
};


var billUpyog = function () {
    var totalBillVal = deciFormat(parseFloat(samanYog()) + parseFloat(shipTot()))-coupon();
    $("#mahayog").html(totalBillVal);
    $("#subttlform").val(samanYog());
    $("#invoiceyoghtml").val(totalBillVal);
        $("#bigtotal").html(deciFormat(totalBillVal));






};

var o_rowTotal = function (numb) {
    //most res
    var result;
    var totalValue;
    var amountVal = formInputGet("#amount", numb);
    var priceVal = formInputGet("#price", numb);
    var discountVal = formInputGet("#discount", numb);
    if (discountVal == '') {
        $("#discount-" + numb).val(0);
        discountVal = 0;
    }
    var vatVal = formInputGet("#vat", numb);
    if (vatVal == '') {
        $("#vat-" + numb).val(0);
        vatVal = 0;
    }
    var taxo = 0;
    var disco = 0;
    var totalPrice = (parseFloat(amountVal).toFixed(2)) * priceVal;
    var tax_status = $("#taxformat option:selected").val();
    var disFormat = $("#discount_format").val();

    //tax after bill
    if (tax_status == 'yes') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = precentCalc(totalPrice, vatVal);
            totalValue = parseFloat(totalPrice) + parseFloat(Inpercentage);
            taxo = deciFormat(Inpercentage);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discountVal);
            }
            else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            }
            else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax
            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = parseFloat(totalValue) + parseFloat(Inpercentage);
            taxo = deciFormat(Inpercentage);


        }
    }
    else if (tax_status == 'inclusive') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = (+totalPrice * +vatVal) / (100 + +vatVal);
            totalValue = parseFloat(totalPrice);
            taxo = deciFormat(Inpercentage);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discountVal);
            }
            else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            }
            else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax
            var Inpercentage = (+totalPrice * +vatVal) / (100 + +vatVal);
            totalValue = parseFloat(totalValue);
            taxo = deciFormat(Inpercentage);


        }
    }
    else {
        taxo = 0;
        if (disFormat == '%' || disFormat == 'flat') {
            //tax

            //  totalValue = deciFormat(totalPrice);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            }
            else if (disFormat == '%') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            }
            else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax


        }
    }
    $("#result-" + numb).html(deciFormat(totalValue));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).text(taxo);
    $("#disca-" + numb).val(disco);
    var totalID = "#total-" + numb;
    $(totalID).val(deciFormat(totalValue));
    samanYog();
};
var rowTotal = function (numb) {
    //most res
    var result;
    var page = '';
    var totalValue;
    var amountVal = formInputGet("#amount", numb);
    var priceVal = formInputGet("#price", numb);
    var discountVal = formInputGet("#discount", numb);
    if (discountVal == '') {
        $("#discount-" + numb).val(0);
        discountVal = 0;
    }
    var vatVal = formInputGet("#vat", numb);
    if (vatVal == '') {
        $("#vat-" + numb).val(0);
        vatVal = 0;
    }
    var taxo = 0;
    var disco = 0;
    var totalPrice = (parseFloat(amountVal).toFixed(2)) * priceVal;
    var tax_status = $("#taxformat option:selected").val();
    var disFormat = $("#discount_format").val();
    if ($("#inv_page").val() == 'new_i' && formInputGet("#pid", numb) > 0) {
        var alertVal = formInputGet("#alert", numb);
        if (+alertVal <= +amountVal) {
            var aqt = +alertVal - +amountVal;
            alert('Low Stock! ' + aqt);
        }
    }

    //tax after bill
    if (tax_status == 'yes') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = precentCalc(totalPrice, vatVal);
            totalValue = parseFloat(totalPrice) + parseFloat(Inpercentage);
            taxo = deciFormat(Inpercentage);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discountVal);
            }
            else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            }
            else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax
            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = parseFloat(totalValue) + parseFloat(Inpercentage);
            taxo = deciFormat(Inpercentage);


        }
    }
    else if (tax_status == 'inclusive') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = (+totalPrice * +vatVal) / (100 + +vatVal);
            totalValue = parseFloat(totalPrice);
            taxo = deciFormat(Inpercentage);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discountVal);
            }
            else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            }
            else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax
            var Inpercentage = (+totalPrice * +vatVal) / (100 + +vatVal);
            totalValue = parseFloat(totalValue);
            taxo = deciFormat(Inpercentage);


        }
    }
    else {
        taxo = 0;
        if (disFormat == '%' || disFormat == 'flat') {
            //tax

            //  totalValue = deciFormat(totalPrice);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            }
            else if (disFormat == '%') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            }
            else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax


        }
    }
    $("#result-" + numb).html(deciFormat(totalValue));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).text(taxo);
    $("#disca-" + numb).val(disco);
    var totalID = "#total-" + numb;
    $(totalID).val(deciFormat(totalValue));
    samanYog();
};
var changeTaxFormat = function (getSelectv) {

    if (getSelectv == 'yes') {
        var tformat = $('#taxformat option:selected').data('tformat');
        var trate = $('#taxformat option:selected').data('trate');
        $("#tax_status").val(tformat);
        $("#tax_format").val('%');
    }
    else if (getSelectv == 'inclusive') {
        var tformat = $('#taxformat option:selected').data('tformat');
        var trate = $('#taxformat option:selected').data('trate');
        $("#tax_status").val(tformat);
        $("#tax_format").val('incl');

    }
    else {
        $("#tax_status").val('no');
        $("#tax_format").val('off');

    }
    var discount_handle = $("#discountFormat").val();
    var tax_handle = $("#tax_format").val();
    formatRest(tax_handle, discount_handle, trate);

}

var changeDiscountFormat = function (getSelectv) {
    if (getSelectv != '0') {
        $(".disCol").show();
        $("#discount_handle").val('yes');
        $("#discount_format").val(getSelectv);
    }
    else {
        $("#discount_format").val(getSelectv);
        $(".disCol").hide();
        $("#discount_handle").val('no');
    }
    var tax_status = $("#tax_format").val();
    formatRest(tax_status, getSelectv);
}

function formatRest(taxFormat, disFormat, trate = '') {
    var amntArray = [];
    var idArray = [];
    $('.amnt').each(function () {
        var v = deciFormat($(this).val());
        var id_e = $(this).attr('id');
        id_e = id_e.split("-");
        idArray.push(id_e[1]);
        amntArray.push(v);
    });
    var prcArray = [];
    $('.prc').each(function () {
        var v = deciFormat($(this).val());
        prcArray.push(v);
    });
    var vatArray = [];
    $('.vat').each(function () {
        if (trate) {
            $(this).val(trate);
            var v = deciFormat(trate);
        }
        else {
            var v = deciFormat($(this).val());
        }

        vatArray.push(v);
    });

    var discountArray = [];
    $('.discount').each(function () {
        var v = deciFormat($(this).val());
        discountArray.push(v);
    });


    var taxr = 0;
    var discsr = 0;
    for (var i = 0; i < idArray.length; i++) {
        var x = idArray[i];

        amtVal = amntArray[i];
        prcVal = prcArray[i];
        vatVal = vatArray[i];
        discountVal = discountArray[i];
        var result = amtVal * prcVal;
        if (vatVal == '') {
            vatVal = 0;
        }
        if (discountVal == '') {
            discountVal = 0;
        }
        if (taxFormat == '%') {
            if (disFormat == '%' || disFormat == 'flat') {

                var Inpercentage = precentCalc(result, vatVal);
                var result = parseFloat(result) + Inpercentage;
                taxr = parseFloat(taxr) + parseFloat(Inpercentage);
                $("#texttaxa-" + x).html(deciFormat(Inpercentage));
                $("#taxa-" + x).val(deciFormat(Inpercentage));

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    var result = parseFloat(result) - parseFloat(Inpercentage);
                    $("#disca-" + x).val(deciFormat(Inpercentage));
                    discsr = parseFloat(discsr) + parseFloat(Inpercentage);
                } else if (disFormat == 'flat') {
                    var result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(deciFormat(discountVal));
                    discsr += parseFloat(discountVal);
                }
            }
            else {
                if (disFormat == 'b_p') {
                    var Inpercentage = precentCalc(result, discountVal);
                    var result = parseFloat(result) - parseFloat(Inpercentage);
                    $("#disca-" + x).val(deciFormat(Inpercentage));
                    discsr = parseFloat(discsr) + parseFloat(Inpercentage);
                } else if (disFormat == 'bflat') {
                    var result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(deciFormat(discountVal));
                    discsr += parseFloat(discountVal);
                }

                var Inpercentage = precentCalc(result, vatVal);
                var result = parseFloat(result) + Inpercentage;
                taxr = parseFloat(taxr) + parseFloat(Inpercentage);
                $("#texttaxa-" + x).html(deciFormat(Inpercentage));
                $("#taxa-" + x).val(deciFormat(Inpercentage));

            }
        }

        else if (taxFormat == 'incl') {

            if (disFormat == '%' || disFormat == 'flat') {


                var Inpercentage = (+result * +vatVal) / (100 + +vatVal);
                var result = parseFloat(result);
                taxr = parseFloat(taxr) + parseFloat(Inpercentage);
                $("#texttaxa-" + x).html(deciFormat(Inpercentage));
                $("#taxa-" + x).val(deciFormat(Inpercentage));

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    var result = parseFloat(result) - parseFloat(Inpercentage);
                    $("#disca-" + x).val(deciFormat(Inpercentage));
                    discsr = parseFloat(discsr) + parseFloat(Inpercentage);
                } else if (disFormat == 'flat') {
                    var result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(deciFormat(discountVal));
                    discsr += parseFloat(discountVal);
                }
            }
            else {
                if (disFormat == 'b_p') {
                    var Inpercentage = precentCalc(result, discountVal);
                    var result = parseFloat(result) - parseFloat(Inpercentage);
                    $("#disca-" + x).val(deciFormat(Inpercentage));
                    discsr = parseFloat(discsr) + parseFloat(Inpercentage);
                } else if (disFormat == 'bflat') {
                    var result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(deciFormat(discountVal));
                    discsr += parseFloat(discountVal);
                }


                var Inpercentage = (+result * +vatVal) / (100 + +vatVal);
                var result = parseFloat(result);
                taxr = parseFloat(taxr) + parseFloat(Inpercentage);
                $("#texttaxa-" + x).html(deciFormat(Inpercentage));
                $("#taxa-" + x).val(deciFormat(Inpercentage));

            }
        }
        else {

            if (disFormat == '%' || disFormat == 'flat') {

                var result = parseFloat($("#amount-" + x).val()) * parseFloat($("#price-" + x).val());
                $("#texttaxa-" + x).html('Off');
                $("#taxa-" + x).val(0);
                taxr += 0;

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    var result = parseFloat(result) - parseFloat(Inpercentage);
                    $("#disca-" + x).val(deciFormat(Inpercentage));
                    discsr = parseFloat(discsr) + parseFloat(Inpercentage);
                } else if (disFormat == 'flat') {
                    var result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(deciFormat(discountVal));
                    discsr += parseFloat(discountVal);
                }
            }
            else {
                if (disFormat == 'b_p') {
                    var Inpercentage = precentCalc(result, discountVal);
                    var result = parseFloat(result) - parseFloat(Inpercentage);
                    $("#disca-" + x).val(deciFormat(Inpercentage));
                    discsr = parseFloat(discsr) + parseFloat(Inpercentage);
                } else if (disFormat == 'bflat') {
                    var result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(deciFormat(discountVal));
                    discsr += parseFloat(discountVal);
                }

                //   var result = parseFloat($("#amount-" + i).val()) * parseFloat($("#price-" + i).val());
                $("#texttaxa-" + x).html('Off');
                $("#taxa-" + x).val(0);
                taxr += 0;

            }
        }

        $("#total-" + x).val(deciFormat(result));
        $("#result-" + x).html(deciFormat(result));



    }
  var sum = deciFormat(samanYog());
        $("#subttlid").html(sum);
        $("#taxr").html(deciFormat(taxr));
        $("#discs").html(deciFormat(discsr));
             billUpyog();

}
//remove productrow


    $('#saman-row').on('click', '.removeProd', function () {

        var pidd = $(this).closest('tr').find('.pdIn').val();
        var pqty = $(this).closest('tr').find('.amnt').val();
        pqty = pidd + '-' + pqty;
        $('<input>').attr({
            type: 'hidden',
            id: 'restock',
            name: 'restock[]',
            value: pqty
        }).appendTo('form');
        $(this).closest('tr').remove();
        $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
        $('.amnt').each(function (index) {
            rowTotal(index);
            billUpyog();
        });

        return false;
    });
    $('#productname-0').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
              data: 'name_startsWith='+request.term+'&type=product_list&row_num=1&wid='+$("#s_warehouses option:selected").val()+'&'+d_csrf,
                success: function (data) {
                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                var t_r = $("#taxformat option:selected").attr('data-trate');
            }
               var discount = ui.item.data[4];
          var custom_discount=$('#custom_discount').val();
          if(custom_discount>0) discount=deciFormat(custom_discount);
            $('#amount-0').val(1);
            $('#price-0').val(ui.item.data[1]);
            $('#pid-0').val(ui.item.data[2]);
            $('#vat-0').val(t_r);
            $('#discount-0').val(discount);
            $('#dpid-0').val(ui.item.data[5]);
            $('#unit-0').val(ui.item.data[6]);
            $('#hsn-0').val(ui.item.data[7]);
            $('#alert-0').val(ui.item.data[8]);
            rowTotal(0);

            billUpyog();


        }
    });
    $(document).on('click', ".select_pos_item", function (e) {
        var pid = $(this).attr('data-pid');
        var stock = $(this).attr('data-stock');
        var flag = true;
           var discount = $(this).attr('data-discount');
          var custom_discount=$('#custom_discount').val();
          if(custom_discount>0) discount=deciFormat(custom_discount);
        $('.pdIn').each(function () {

            if (pid == $(this).val()) {

           var pi = $(this).attr('id');
                var arr = pi.split('-');
                pi = arr[1];
             $('#discount-' + pi).val(discount);
                var stotal = +deciFormat($('#amount-' + pi).val()) + 1;

                if (stotal <= stock) {
                    $('#amount-' + pi).val(+deciFormat($('#amount-' + pi).val()) + +1);
                     $('#search_bar').val('').focus();
                }
                else {
                    $('#stock_alert').modal('toggle');
                }
                rowTotal(pi);
                billUpyog();
     $('#amount-'+pi).focus();
                flag = false;
            }
        });
        var t_r = $(this).attr('data-tax');
        if ($("#taxformat option:selected").attr('data-trate')) {

            var t_r = $("#taxformat option:selected").attr('data-trate');
        }
        if (flag) {
            var ganak = $('#ganak').val();
            var cvalue = parseInt(ganak);
            var functionNum = "'" + cvalue + "'";
            count = $('#saman-row div').length;
            var data = '<tr id="ppid-' + cvalue + '" class="mb-1"><td colspan="7" ><input type="text" class="form-control text-center" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '" value="' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '"><input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-stock') + '"  name="alert[]"></td></tr><tr><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ></td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + $(this).attr('data-price') + '"></td><td> <input type="text" class="form-control vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + t_r + '"></td>  <td><input type="text" class="form-control discount pos_w" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + discount + '"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeItem" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-pid') + '"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + $(this).attr('data-unit') + '"> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-pcode') + '"></tr>';

            //ajax request
            // $('#saman-row').append(data);
            $('#pos_items').append(data);
            rowTotal(cvalue);
            billUpyog();
            $('#ganak').val(cvalue + 1);
              $('#amount-'+cvalue).focus();

        }
    });

       $(document).on('click', ".v2_select_pos_item", function (e) {
        var pid = $(this).attr('data-pid');
        var stock = $(this).attr('data-stock');
          var discount = $(this).attr('data-discount');
          var custom_discount=$('#custom_discount').val();
          if(custom_discount>0) discount=deciFormat(custom_discount);
        var flag = true;
        $('.pdIn').each(function () {

            if (pid == $(this).val()) {

             var pi = $(this).attr('id');
                var arr = pi.split('-');
                pi = arr[1];
             $('#discount-' + pi).val(discount);
                var stotal = +deciFormat($('#amount-' + pi).val()) + 1;

                if (stotal <= stock) {
                    var new_s=+deciFormat($('#amount-' + pi).val())+1;
                    $('#amount-' + pi).val(new_s);
                     $('#search_bar').val('').focus();
                }
                else {
                    $('#stock_alert').modal('toggle');
                }
                rowTotal(pi);
                billUpyog();

                flag = false;
            }
        });
        var t_r = $(this).attr('data-tax');
        if ($("#taxformat option:selected").attr('data-trate')) {

            var t_r = $("#taxformat option:selected").attr('data-trate');
        }
        var sound = document.getElementById("beep");
          sound.play();
        if (flag) {
            var ganak = $('#ganak').val();
            var cvalue = parseInt(ganak);
            var functionNum = "'" + cvalue + "'";
            count = $('#saman-row div').length;
            var data = ' <div class="row  m-0 pt-1 pb-1 border-bottom"  id="ppid-' + cvalue + '"> <div class="col-6 "> <span class="quantity"><input type="number" class="form-control req amnt display-inline mousetrap" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ><div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div></span>' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '</div> <div class="col-3"> ' + $(this).attr('data-price') + ' </div> <div class="col-3"><strong><span class="ttlText" id="result-' + cvalue + '">0</span></strong><a data-rowid="' + cvalue + '" class="red removeItem" title="Remove"> <i class="fa fa-trash"></i> </a></div><input type="hidden" class="form-control text-center" name="product_name[]" id="productname-' + cvalue + '" value="' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '"><input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-stock') + '"  name="alert[]"><input type="hidden" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + $(this).attr('data-price') + '"> <input type="hidden" class="form-control vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + t_r + '"><input type="hidden" class="form-control discount pos_w" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + discount + '"><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-pid') + '"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + $(this).attr('data-unit') + '"><input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-pcode') + '"></div>';
            //ajax request
            // $('#saman-row').append(data);
            $('#pos_items').append(data);
            rowTotal(cvalue);
            billUpyog();
            $('#ganak').val(cvalue + 1);
            $('#amount-'+cvalue).focus();
        }
    });

           $('#saman-pos2').on('click', '.removeItem', function () {
        var pidd = $(this).attr('data-rowid');
        var pqty = $('#amount-'+pidd).val();
        var old_amnt = $('#amount_old-'+pidd).val();
        if (old_amnt) {
            pqty = pidd + '-' + pqty;
            $('<input>').attr({
                type: 'hidden',
                name: 'restock[]',
                value: pqty
            }).appendTo('form');
        }
        $('#ppid-'+pidd).remove();
        $('.amnt').each(function (index) {
            rowTotal(index);
        });
        billUpyog();
        return false;
    });



        $('#saman-row-pos').on('click', '.removeItem', function () {

        var pidd = $(this).closest('tr').find('.pdIn').val();
        var pqty = $(this).closest('tr').find('.amnt').val();
        var old_amnt = $(this).closest('tr').find('.old_amnt').val();
        if (old_amnt) {
            pqty = pidd + '-' + pqty;
            $('<input>').attr({
                type: 'hidden',
                name: 'restock[]',
                value: pqty
            }).appendTo('form');
        }
        $(this).closest('tr').remove();
        $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
        $('#p' + $(this).closest('tr').find('.pdIn').attr('id')).remove();
        $('.amnt').each(function (index) {
            rowTotal(index);

        });
            billUpyog();


        return false;

    });





$(document).on('click', ".quantity-up", function (e) {
    var spinner = $(this);
         var input = spinner.closest('.quantity').find('input[name="product_qty[]"]');
        var oldValue = parseFloat(input.val());

        var newVal = oldValue + 1;
        spinner.closest('.quantity').find('input[name="product_qty[]"]').val(newVal);
         spinner.closest('.quantity').find('input[name="product_qty[]"]').trigger("change");

           var  id_arr = $(input).attr('id');
            id = id_arr.split("-");
              rowTotal(id[1]);
                 billUpyog();

        return false;

});

$(document).on('click', ".quantity-down", function (e) {
    var spinner = $(this);
         var input = spinner.closest('.quantity').find('input[name="product_qty[]"]');
        var oldValue = parseFloat(input.val());

        min=1;
          if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }

        spinner.closest('.quantity').find('input[name="product_qty[]"]').val(newVal);
         spinner.closest('.quantity').find('input[name="product_qty[]"]').trigger("change");


        var  id_arr = $(input).attr('id');
            id = id_arr.split("-");
              rowTotal(id[1]);
                 billUpyog();
        return false;

});



