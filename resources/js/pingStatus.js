import './bootstrap';

window.Echo.channel('sendStreamRequest')
.listen('.streamPaymentRequest',(e)=>{
    console.log(e);
    // $("#guestPaymentModalTitle").text(e.message);
    // $("#paymentModal").modal('show');
});

