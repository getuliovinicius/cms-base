// JavaScript Document
function menuAcao(modulo) {
	document.getElementById(modulo).style.background = '#FFF';
	if (document.getElementById(modulo + 'Acao')) {
		document.getElementById(modulo + 'Acao').style.display = 'block';
	}
}