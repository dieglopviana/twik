$(document).ready(function(){
								
	var auctions = '';
	
	$('.quadro_auction').each(function(){
		var leiloes = $(this).attr('title');
		var aids = leiloes.split(': ');
		var auctionId = aids[1];
		
		if(auctionId){
			auctions += auctionId + ',';
		}
	});	
	
	// Main countdown for updating auction and flashing
    setInterval(function(){		
        if ($('#history_bids').length){
			getStatusUrl = '/getstatus.php?histories=yes';			
		} else {		
			getStatusUrl = '/getstatus.php';
		}
		
		$.ajax({
   			url: getStatusUrl,
            dataType: 'json',
            type: 'POST',
            timeout: 2999,
            global: false,
   			data: "auctions=" + auctions,
   			success: function(resposta){
   				
				$.each(resposta, function(i, item){
					var idAuction   = item.Auction.id;
					var quadroAviso = $('#quadro_aviso_' + idAuction);
					var quadroTime  = $('#quadro_time_' + idAuction);
					var time        = $('#time_' + idAuction);
					var txtSegundos = $('#txt_segundos_' + idAuction); 
					var arrematado  = $('#arrematado_' + idAuction);
					var valLastBid  = $('#valor_last_bid_' + idAuction);
					var valArremate = $('#valor_arrematado_' + idAuction);
					
					$('#data_hora').text(item.Hora.server);
					
					if(item.LastBid){
						if(item.LastBid.valor == 0){
							valLastBid.text('R$ 0,0' + item.LastBid.valor);
						} else {
							valLastBid.text('R$ ' + item.LastBid.valor);
						}
					
						if(item.LastBid.foto_user != 0){
							var image_user = "<img src=/img/imagens_users/thumbs/" + item.LastBid.foto_user + " border=0 alt=" + item.LastBid.username + " title=" + item.LastBid.username + " class='img_bid_user' />";
							$('#img_user_' + idAuction).html(image_user);	
						} else {
							var image_user = "<img src=/img/user_exemplo.png border=0 alt=" + item.LastBid.username + " title=" + item.LastBid.username + " class='img_bid_user' />";
							$('#img_user_' + idAuction).html(image_user);		
						}
					}
					
					if(item.Auction.iniciar == 1){
						quadroAviso.css('display', 'none');
						quadroTime.css('display', 'block');
						
						$('#btn_lance_' + idAuction).html('<img src="/img/bt_lance_vd.png" border="0" alt="" />');
											
						if(item.Auction.cronometro <= 10){
							time.css('color', '#990000');
							txtSegundos.css('color', '#990000');
						} else {
							time.css('color', '#339900');
							txtSegundos.css('color', '#339900');
						}
						
						if(item.Auction.cronometro >= 60){
							txtSegundos.css('display', 'none');
							time.text(calc_counter_from_time(item.Auction.cronometro));
						} else {
							txtSegundos.css('display', 'block');
							if(item.Auction.cronometro < 10){
								time.text('0' + item.Auction.cronometro);
							} else {
								time.text(item.Auction.cronometro);
							}
						}
						 
						if(item.Auction.arrematado == 1){
							quadroTime.css('display', 'none');
							arrematado.css('display', 'block');
							
							if(item.LastBid.valor == 0){
								valArremate.text('R$ 0,0' + item.LastBid.valor);
							} else {
								valArremate.text('R$ ' + item.LastBid.valor);
							}
							
							$('#bt_lance_' + idAuction).html('<img src="/img/bt_lance_end.png" border="0" alt="" />');
						}
					}				
					
					if ($('#history_bids').length){
						$('.history_bids tr').remove();
						if (item.LatestBids == 0){
							var noBid = "<tr class='first_bid'><td align='center'><span class='valor_bid'><strong>Nenhum lance ainda, valor inicial R$ " + item.LastBid.valor + "</strong></span></td></tr>";
							$('.history_bids').append(noBid);
						} else {
							$('.history_bids tr').remove();
						}
						
						if (item.Auction.iniciar == 1){
							$('#topo_inativo').css('display', 'none');
							$('#topo_ativo').css('display', 'block');							
						}
						
						var a = 1; //Indica nos detalhes do Leil�o a primeira linha
						$.each(item.LatestBids, function(n, bids){
							if (item.Auction.arrematado != 1){
								if (a == 1){
									var row = "<tr class='first_bid'><td class='valor_bid' align='center'><span class='fisrt_bid'><strong>R$ " + bids.valor + "</strong></span></td><td class='imagem_user' align='center'><img src='/img/imagens_users/thumbs/" + bids.foto_user + "' alt='' /></td><td class='username'><span class='username'>" + bids.username + "</span></td></tr>";
								} else {
									var row = "<tr><td class='valor_bid' align='center'><span class='valor_bid'><strong>R$ " + bids.valor + "</strong></span></td><td class='imagem_user' align='center'><img src='/img/imagens_users/thumbs/" + bids.foto_user + "' alt='' /></td><td class='username'><span class='username'>" + bids.username + "</span></td></tr>";
								}
							} else {
								$('#topo_inativo').css('display', 'none');
								$('#topo_ativo').css('display', 'none');
								$('.topo_arrematado').css('display', 'block');
															
								if (a == 1){
									//var row = "<tr id='first'><td class='valor_bid' align='center'><span class='valor_bid'><strong>R$ " + bids.valor + "</strong></span></td><td class='imagem_user' align='center'><img src='/img/imagens_users/thumbs/" + bids.foto_user + "' alt='' /></td><td class='username'><span class='username'>" + bids.username + "</span></td></tr>";
									var row = "<tr id='arrematado_'" + idAuction + "'><td id='aviso_arremate' colspan='3' class='leilao_arrematado'><div id='foto_winner'><img src='/img/imagens_users/max/" + bids.foto_user + "' width='50px' height='50px' alt='' /></div><div id='txt_winner'><span><strong>arrematado por </strong></span><span id='username_winner'>" + bids.username + "</span><br /><span id='valor_arrematado_'" + idAuction + "' class='valor_arrematado_detalhe'><strong>R$ " + bids.valor + "</strong></span></div></td></tr>";
								} else {
									var row = "<tr><td class='valor_bid' align='center'><span class='valor_bid'><strong>R$ " + bids.valor + "</strong></span></td><td class='imagem_user' align='center'><img src='/img/imagens_users/thumbs/" + bids.foto_user + "' alt='' /></td><td class='username'><span class='username'>" + bids.username + "</span></td></tr>";
								}
							}
							
							$('.history_bids').append(row);
							a++;
						});	
					}
					
				});

   			}
 		});
    }, 1000);

    // Function for bidding
    $('.btn_lance').click(function(){
		if ($(this).attr('title') == 'login'){
			location.href='/users/login';	
		}
		
		$.ajax({
            url: $(this).attr('href'),
            dataType: 'json',
            success: function(data){
				$('#qtd_lances_' + data.User.id).html(data.UserBid.quantidade);
            }
        });

        return false;
    });

    if($('.productImageThumb').length){
        $('.productImageThumb').click(function(){
            $('.productImageMax').fadeOut('fast').attr('src', $(this).attr('href')).fadeIn('fast');
            return false;
        });
    }
	
/*	$('.btn_lance').hover(
		function(){
			if ($(this).attr('title') == 'login'){
				$(this).html('<img src="/img/bt_login.png" border="0" alt="" />');	
			}				  
		},
		function(){
			//if (item.Auction.iniciar == 1){
			//	$(this).html('<img src="/img/bt_lance_vd.png" border="0" alt="" />');
			//} else {
				$(this).html('<img src="/img/bt_lance_la.png" border="0" alt="" />');
			//}
		}
	);
*/

/*    if($('#CategoryId').length){
        $('#CategoryId').change(function(){
            document.location = '/categories/view/' + $('#CategoryId option:selected').attr('value');
        });
    }

    if($('#myselectbox').length){
        $('#myselectbox').change(function(){
            document.location = '/categories/view/' + $('#myselectbox option:selected').attr('value');
        });
    }*/

});


function calc_counter_from_time(diff) {

	if (diff > 0) {
		hours=Math.floor(diff / 3600)

		minutes=Math.floor((diff / 3600 - hours) * 60)

		seconds=Math.round((((diff / 3600 - hours) * 60) - minutes) * 60)
	} else {
		hours = 0;
		minutes = 0;
		seconds = 0;
	}

	if (seconds == 60) {
		seconds = 0;
	}

	if (minutes < 10) {
		if (minutes < 0) {
			minutes = 0;
		}
		minutes = '0' + minutes;
	}
	if (seconds < 10) {
		if (seconds < 0) {
			seconds = 0;
		}
	seconds = '0' + seconds;
	}
	if (hours < 10) {
		if (hours < 0) {
			hours = 0;
		}
		hours = '0' + hours;
	}

	return hours + ":" + minutes + ":" + seconds;
}
