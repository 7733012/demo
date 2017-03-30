$(function(){
	//风云云淡 ui设计 简单点吧
	//添加
	$('#new_form').live('click', function() { 
		var zjfrom_html = $('.zhijiabox .zj_key_from').get(0).outerHTML;
		var z_size = $('.zj_key_from').size()-1;
		$('.zj_key_from').eq(z_size).after(zjfrom_html);

		var z_size = $('.zj_key_from').size()-1;
		$('.zj_key_from').eq(z_size).find('.in_txt').val('');
	});

	//删除
	$('.del_from').live('click', function(){
		var index = $('.del_from').index(this);
		var t_size =  $('.del_from').size();
		if(t_size==1)
		{	
			alert('只有一个账号，不允许删除');
			return false; 
		}
		//$('.zj_key_from:eq('+index+")'").remove();
		$('.zj_key_from').eq(index).remove();
		
	})
	//动态取html bug屏蔽
	$("input").live('blur',function(){  

				this.setAttribute('value',this.value);  

			}); 



	
 
	//保存
	$('#zj_form_save').live('click',function(){
		
				
		var is_zj = window.confirm('^_^ 确定要这样修改账号吗？');
		if(is_zj)
		{

			all_form = $('.zhijiabox').html();
			//alert(all_form);

			$.post('show.php?set_key=1',{'all_html':all_form},function(result){alert(result)});

		}else{
			return false;
		}
	})

	


})	