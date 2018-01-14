$(function(){
	$('.nav .left').animate({'left':'50px'},1000,
		function(){$('.nav .left').animate({'left':'0px'}),1000});
	$('.nav .right').animate({'right':'50px'},1000,
		function(){$('.nav .right').animate({'right':'0px'}),1000});
	$('.navfooter .nav a').animate({'left':'0px'},2000);
	$('.mr div').css('transform','scale(1,1)');
	$('body').scrollTop(0);

	//页面动画效果，根据滚动缓慢显示
	$(window).scroll(function(){
	 	if ($(window).scrollTop()>=250){
			$('.star div .stara').animate({'left':'0px'},2000);
			$('.star div .starb').animate({'right':'0px'},2000);
		}
		if ($(window).scrollTop()>=900){
			$('.you div').css('transform','scale(1,1)');
		}
		if ($(window).scrollTop()>=1200){
			$('.our').css('transform','scale(1,1)');
		}
		if ($(window).scrollTop()>=1500){
			$('.wel').css('transform','scale(1,1)');
		}
		if ($(window).scrollTop()>=2200){
			$('.imgs').animate({'left':'0px'},2000);
		}
		if ($(window).scrollTop()>=3000){
			$('.footera div div').css('transform','scale(1,1)');
		}
		if ($(window).scrollTop()>=3000){
			$('.footerb div').css('transform','scale(1,1)');
		}
	});
var put=document.getElementById('put1');
	put.onfocus=function(){
			this.value='';
	};
	put.onblur=function(){
		if (this.value=='') {
			this.value='Email';
		}
	}
});
window.onload=function(){
	setTimeout(function(){
		window.scrollTo(0,0);
	},0)
};


/*** 只填两个必要参数也是可以的 */
// var banenr2 = new FragmentBanner({
// 	container: "#banner2", //选择容器 必选
// 	imgs: ['images/1.jpg', 'images/2.jpg', 'images/3.jpg', 'images/4.jpg', 'images/5.jpg'], //图片集合
// });