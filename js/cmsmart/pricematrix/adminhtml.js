/**
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */


function createMatrix(url){
    var serializeData = $j('#matrix-data input').serializeArray();
    var hasVerticalCheck = false;
    var hasHorizontalCheck = false;
    for (var i= 0; i<serializeData.length; ++i){
        if(serializeData[i].name == 'attr[vertical][]'){
            hasVerticalCheck = true;
        }

        if(serializeData[i].name == 'attr[horizontal][]'){
            hasHorizontalCheck = true;
        }
    }

    if(hasVerticalCheck && hasHorizontalCheck){
        $j('#loading-mask').show();
        $j.ajax({
//        url: '<?php echo Mage::getUrl("pricematrix/index/matrix"); ?>',
            url: url,
            type: 'post',
            dataType: 'json',
            data: serializeData,
            success: function(response){
                $j('#loading-mask').hide();
                $j('#matrix-result').html(response);
            }
        });
    }else{
        alert('Please choose group custom option before submit !');
        return;
    }

};

function getData(direction, url){

    var serializeData = $j('#'+direction+'-attributes input').serializeArray();
    var hasCheck = false;
    for (var i= 0; i<serializeData.length; ++i){
        if(serializeData[i].name == 'attr[]'){
            hasCheck = true;
            break;
        }
    }

    if(hasCheck){
        $j('#loading-mask').show();
        $j.ajax({
//        url: '<?php echo Mage::getUrl("pricematrix/index/index"); ?>',
            url: url,
            type: 'post',
            dataType: 'json',
            data: serializeData,
            success: function(response){
                $j('#loading-mask').hide();
                $j('#sub-'+ direction +'-result').html('');
                for(var i=0; i<response.length; i++){
                    $j('<div class="item"><input type="checkbox" class="'+ direction +'-checkbox" name="attr['+direction+'][]" value=\''+ JSON.stringify(response[i]) +'\' />'+response[i]['full_title']+'</div>').appendTo('#sub-'+ direction +'-result');
                }
            }
        });
    }else{
        alert('Please choose custom option before submit !');
        return;
    }

}

function toggleSelect(type,direct){
    if(type == 'select'){
        $j('.'+direct+'-checkbox').each(function() { //loop through each checkbox
            this.checked = true;  //select all checkboxes with class "checkbox1"
        });
    }

    if(type == 'unselect'){
        $j('.'+direct+'-checkbox').each(function() { //loop through each checkbox
            this.checked = false; //deselect all checkboxes with class "checkbox1"
        });
    }
}

$j(document).ready(function(){
    $j('#pricematrix-table').tooltip({
        content: function () {
            return $j(this).prop('title');
        }
    });
});