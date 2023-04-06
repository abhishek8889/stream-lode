import './bootstrap';

window.Echo.channel('sendStreamRequest')
.listen('.streamPaymentRequest',(e)=>{
    $("#guestPaymentModalTitle").text(e.message);
    $("#paymentModal").modal('show');
});

