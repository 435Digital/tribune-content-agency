	var ua = new RegExp (navigator.userAgent);
	var opera = /Opera Mini/.test(ua);
	function toggler(toggle_id,button_id){
		t_id = document.getElementById(toggle_id);
		b_id = document.getElementById(button_id);

		if (b_id.getAttribute('href')!==null){
			b_id.removeAttribute('href');
		}

		t_state = t_id.getAttribute('data-toggle');

		if( t_state == ''||t_state==null){
			t_id.setAttribute('data-toggle','true');
			t_id.removeAttribute('href');
			}

		else{
			t_id.setAttribute('data-toggle','');
			}
	}
    document.getElementById('body').setAttribute('data-ua',navigator.userAgent);

    if(opera==false){
	    document.getElementById("nav-open").addEventListener("click", function(){
	   		toggler('header','nav-open');
		});
	}
