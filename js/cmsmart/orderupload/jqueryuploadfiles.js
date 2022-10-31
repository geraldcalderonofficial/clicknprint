//"use strict";
(function($){
$.fn.magicFiles=function(settings){
	var options=$.extend({},{
		maxFiles:Infinity,
		minFiles:0,
		preFillDescription:false,
		requireDescriptions:false,
		missingDescription:"Description required.",
		tooMany:'Too many.',
		checkFile:function(file){
			// ignore file.type and file.size. let anything through!
			return true
		},
		description:
			'<div class="fileDescription">\
				<button type="button">X<\/button>\
				<span><\/span>\
				<textarea name="descriptions[]" rows="3" cols="35"></textarea>\
				<b class="error"><\/b>\
			<\/div>',
		onLoad:function(){ // Got an upload response! 
			//deal with contents
			var form=$(this).closest('form')
			var response=$(this).contents().find('body').html()
			// $('.status',form).append( response )
			if(response) $('.status',form).html( response )
			//clean up form
			$('.reset',form).click()
			form.trigger('loaded',[response])
		},
		onSubmit:function(e){
			var error=false,
				descs=$('.fileDescription textarea',this)
			if (options.requireDescriptions)
				descs.each(function(descriptionNumber){
					var v=$(this).val(),
						bad=v.length==0 || v.match(/^\s*$/)!=null
					$(this).toggleClass('required',bad)
					$(this).siblings('.error').text(bad?options.missingDescription:'')
					if (descriptionNumber+1>options.maxFiles){
						bad=true
						$(this).siblings('.error').text(options.tooMany)
					}
					if (bad) error=true
				})
			if(!error) // cleanup the empty file.
				$('[type=file]:last',this).attr('disabled','disabled')
			return !error
		}
	},settings)
	return this.each(function(){
		var form=$(this)
		form.on('change','[type=file]',function(evt){
			var e=evt.originalEvent,
				label=$(this).closest('label'),
				good=true,
				files=this.files;
			if (!(files && files.length)){
				files=[{ // non-html5 kludge
					name:$(this).val().replace(/^.*\\([^\\]*$)/,"$1"),
					size:1,
					type:"unknown/fileType"
				}]
			}
			$.each(files,function(i,file){
				if (!options.checkFile(file)) good=false
			})
			if(!good) {
				$(this).val('')
			}else{
				$('[type=submit]',form).removeAttr('disabled')
				$.each(files,function(i,file){
					$(options.description)
						.appendTo($('.descriptions',form))
						.find('input').val(options.preFillDescription?file.name:'')
						.end()
						.find('span').text(file.name)
						.end()
						.find('.error').text(
							$('.fileDescription',form).length>options.maxFiles?options.tooMany:''
						)
				})
				label.clone().insertAfter(label.hide())
			}
		})
		.on('click','.fileDescription button',function(evt){
			var index=$('.fileDescription button').index(this)
			$(this).closest('div.fileDescription').remove()
			$('[type=file]',form).closest('label.file').eq(index).remove()
			if ($('.fileDescription',form).length<options.minFiles)
				$('[type=submit]',form).attr('disabled','disabled')
			return false
		})
		.submit(options.onSubmit)
		if (options.minFiles>0)
			$('[type=submit]',form).attr('disabled','disabled')
		$('.reset',form).click(function(){
			$('.descriptions',form).empty()
			$('[type=file]',form).slice(0,-1).closest('label.file').remove()
			$('[type=file]',form).removeAttr('disabled').show()
			form[0].reset()
			if (options.minFiles>0)
				$('[type=submit]',form).attr('disabled','disabled')
			return false
		})
		$('iframe',form).load(options.onLoad)
	})
}

})(jQuery);
jQuery(document).ready(function(){
	jQuery('.box_upload a.show_upload').click(function(){
		// alert(123);
		jQuery('#upload_files_nbm div.status').html(jQuery('#list_allimages').html());
	})
});