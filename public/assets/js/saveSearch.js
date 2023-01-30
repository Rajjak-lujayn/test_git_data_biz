$(document).ready(function () {

    dataForSave= [];

    $('#saveSearch').click(function () {

        topFilter = [];

        countryList = [];
        $(".locationicon ul li").each( function(){
            
            if($(this).attr("title") !== undefined){
                countryList.push($(this).attr("title"));
            }
        
        });
        topFilter['country_list']=countryList;


        
        getIndustries = []; 
        $("ul.select2-selection__rendered:first .select2-selection__choice").each( function(){

            getIndustries.push($(this).attr("title"));
                
        });

        topFilter['get_industries'] = getIndustries;


        $("#getSearchTitle").val() ? topFilter['title_search'] = $("#getSearchTitle").val() : '';
        // $(".select2-selection__choice").eq(0).attr("title") ? topFilter['get_industries'] = $(".select2-selection__choice").eq(0).attr("title") : '';
        // $(".select2-selection__choice").eq(1).attr("title") ? topFilter['country_list'] = $(".select2-selection__choice").eq(1).attr("title") : '';

        $("#liveSearchLeftFilter input").each(function () {

            console.log($(this).val());

            if ($(this).val() != '' && $(this).val().length >= 3) {
                let key = $(this).attr("id");
                let value = $(this).val();
                dataForSave[key] = value;
            }
        });

        topFilter = Object.assign({}, topFilter);

        dataForSave['top_filter'] = topFilter;

        dataForSave = Object.assign({}, dataForSave);
        console.log(dataForSave);

        const urlParams = new URLSearchParams(location.search);

        let queryString = window.location.href;
        for (const [key, value] of urlParams) {
            if (key == 'saved_query_id') {
                let queryString = window.location.href;

                queryString = queryString.split('&saved_query_id')[0]
                console.log(queryString)
            }
        }
        
        $.ajax({
            type: "post",
            url: "/save_search_query",
            // cache: false,
            // async: false,
            data: {
                query_string: queryString,
                data_for_save: dataForSave,
                params: dataForSave
            },
            success: function (response) {

                if (response == "0") {
                    console.log("Error to Save Search...");
                } else {
                    console.log(response);
                    $("#saveSearch").text("Saved!");
                }

            }
        });

    });

    function check_search_fields() {

        fieledValues = [];
        $("#liveSearchLeftFilter input").each(function () {
            // console.log($(this).val());
            if ($(this).val() != '') {
                // let key = $(this).attr("id");
                let value = $(this).val();
                // fieledValues[] = value;
                fieledValues.push(value);
            }

        });
        if (fieledValues.length >= 2) {
            console.log("Save Search Enabled...");
            $("#saveSearch").show();
        } else {
            console.log("Save Search Disabled...");
            $("#saveSearch").hide();
        }

        // if (first_name != '' && last_name != '' && customer_email != '' && customer_phone != '') {
        //     $(".lujayn-paypal-payment-btn").removeClass("disabled");
        //     $(".lujayn-paypal-payment-btn").removeAttr("style");
        // } else {
        //     // console.warn("Required field are emplty");
        //     $(".lujayn-paypal-payment-btn").addClass("disabled");
        //     $(".lujayn-paypal-payment-btn").attr("style", "cursor: not-allowed");
        // }
    }

    // validate_checkout_page_form();
    $("#liveSearchLeftFilter input").on("change", function () {
        check_search_fields();
    });

});