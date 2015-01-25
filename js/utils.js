var MESES = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

function updateTips(t) {
	tips.text(t).addClass("ui-state-highlight");
	setTimeout(function() {
		tips.removeClass("ui-state-highlight", 1500);
	}, 500);
}

function checkLength(o, n, min, max) {
	if (o.val().length > max || o.val().length < min) {
		o.addClass("ui-state-error");
		updateTips("Length of " + n + " must be between " + min + " and " + max
				+ ".");
		return false;
	} else {
		return true;
	}
}

function showMonths(currentMonth, currentYear, classMonths) {
	var months = $(classMonths);
	months.empty();
	for ( var month = 1; month <= 12; month++) {
		if (currentMonth == month) {
			months.append($('<div>', {
				"class" : "fm-div-month-selected",
				html : MESES[month-1]
			}));
		} else {
			months.append($('<div>', {
				"class" : "fm-div-month",
				html : MESES[month-1],
				value : month
			}));
		}
	}
	
	$( ".fm-div-month" ).click(function() {
        var month = $(this).attr('value');           
        $.get('lancamentoList.php', {month: month, year: currentYear}, function(data){            
            $(".fm-div-list").html(data);
            showMonths(month, currentYear, '.fm-div-months');
        });             
    });
}

function showMessage(message){
	var divMessage = $(".fm-div-message");
	divMessage.html(message);
	divMessage.animate({opacity: 1, height: 'toggle', top: '20'});
	setTimeout(function() {
		divMessage.animate({opacity: 0, height: 'slideToggle', top: '-20'});
    }, 5000);
	
}

function checkRegexp(o, regexp, n) {
	if (!(regexp.test(o.val()))) {
		o.addClass("ui-state-error");
		updateTips(n);
		return false;
	} else {
		return true;
	}
}