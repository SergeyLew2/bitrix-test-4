$(document).ready(function($) {
    $('#get-popup').click(function() {
        $('#popup-fade_1').fadeIn();
        return false;
    });

    $('#popup-close_1').click(function() {
        $(this).parents('#popup-fade_1').fadeOut();
        return false;
    });

    $(document).keydown(function(e) {
        if (e.keyCode === 27) {
            e.stopPropagation();
            $('#popup-fade_1').fadeOut();
        }
    });

    $('#popup-fade_1').click(function(e) {
        if ($(e.target).closest('#popup_1').length == 0) {
            $(this).fadeOut();
        }
    });
    $('#custom-btn-primary_1').off('click').on('click', function(){

        let data = {"name":$('#custom-input-name_1').val(),
                    "department":$('#custom-input-department_1 option:selected').text(),
                    "departmentValue":$('#custom-input-department_1').val(),
                    "phone":$('#custom-input-phone_1').val(),
                    "token":$('#recaptchaResponse_1').val(),
                    "action": 'add'};
        console.log(data);
        $.ajax({
            url: '/ajax/custom_test/news.list/handler.php',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(response){
                console.log(response);
                if(response.error != undefined) {
                    alert(response.error);
                }
                if(response.success != undefined) {
                    alert(response.success);
                    $('#popup-close_1').trigger('click');
                    let strAdd = '<tr class="custom-tr" data="' + response.postData.id + '">'+
                                    '<td data="name">' + response.postData.name + '</td>'+        
                                    '<td data="department">' + response.postData.department + '</td>'+
                                    '<td data="phone">' + response.postData.phone + '</td>'+
                                    '<td>'+
                                        '<img class="custom-small edit" data="' + response.postData.id + '" src="' + BX.message('TEMPLATE_PATH') + '/images/edit_icon-icons.com_52382.png" />&nbsp;'+
                                        '<img class="custom-small delete" data="' + response.postData.id + '" src="' + BX.message('TEMPLATE_PATH') + '/images/free-icon-delete-14360493.png" />'+
                                    '</td>'+        
    '                             </tr>';
                    $('.table.table-bordered.table-sm').prepend(strAdd);
                    
                }
                
            },
            error: function(jqXhr, json, errorThrown){
                alert(jqXhr.responseText);
            }
        });
    });
});
$(document).ready(function($){
    
    var idElem = ''; 
    
    $('body').on('click', '.edit', function(){
        $('#popup-fade_2').fadeIn('fast');
        
        let selectVal = $(this).parents('tr').find('[data="department"]').text().trim();        
        $('#custom-input-name_2').val($(this).parents('tr').find('[data="name"]').text().trim());
        $('#custom-input-department_2 option:contains("' + selectVal + '")').prop('selected', true);
        $('#custom-input-phone_2').val($(this).parents('tr').find('[data="phone"]').text().trim());
        idElem = $(this).attr('data');
        return false;
    });

    $('#popup-close_2').click(function() {
        $(this).parents('#popup-fade_2').fadeOut();
        return false;
    });

    $(document).keydown(function(e) {
        if (e.keyCode === 27) {
            e.stopPropagation();
            $('#popup-fade_2').fadeOut();
        }
    });

    $('#popup-fade_2').click(function(e) {
        if ($(e.target).closest('#popup_2').length == 0) {
            $(this).fadeOut();
        }
    });
    $('#custom-btn-primary_2').off('click').on('click', function(){

        let data = {"name":$('#custom-input-name_2').val(),
                    "department":$('#custom-input-department_2 option:selected').text(),
                    "departmentValue":$('#custom-input-department_2').val(),
                    "phone":$('#custom-input-phone_2').val(),
                    "token":$('#recaptchaResponse_2').val(),
                    "action": 'edit',
                    "idElem": idElem};
        $.ajax({
            url: '/ajax/custom_test/news.list/handler.php',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(response){
                console.log(response);
                if(response.error != undefined) {
                    alert(response.error);
                }
                if(response.success != undefined) {
                    alert(response.success);
                    $('#popup-close_2').trigger('click');
                    $('tr[data=' + response.postData.id + ']').find('td[data="name"]').text(response.postData.name);
                    $('tr[data=' + response.postData.id + ']').find('td[data="department"]').text(response.postData.department);
                    $('tr[data=' + response.postData.id + ']').find('td[data="phone"]').text(response.postData.phone);
                }
                
            },
            error: function(jqXhr, json, errorThrown){
                alert(jqXhr.responseText);
            }
        });
    });
});
$(document).ready(function($) {
    
    var idElem = ''; 
    
    $('body').on('click', '.delete', function(){
        $('#popup-fade_3').fadeIn('fast');
        idElem = $(this).attr('data');
    });

    $('.custom-not-delete-conf').click(function() {
        $(this).parents('#popup-fade_3').fadeOut();
        return false;
    });

    $(document).keydown(function(e) {
        if (e.keyCode === 27) {
            e.stopPropagation();
            $('#popup-fade_3').fadeOut();
        }
    });

    $('#popup-fade_3').click(function(e) {
        if ($(e.target).closest('#popup_3').length == 0) {
            $(this).fadeOut();
        }
    });
    
    $('.custom-delete-conf').off('click').on('click', function(){

        let data = {"token":$('#recaptchaResponse_3').val(),
                    "action": 'delete',
                    "idElem": idElem};
        $.ajax({
            url: '/ajax/custom_test/news.list/handler.php',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(response){
                console.log(response);
                if(response.error != undefined) {
                    alert(response.error);
                }
                if(response.success != undefined) {
                    alert(response.success);
                    $('.custom-not-delete-conf').trigger('click');
                    $('tr[data=' + response.postData.id + ']').remove();
                }
            },
            error: function(jqXhr, json, errorThrown){
                alert(jqXhr.responseText);
            }
        });
    });
    
    
});
