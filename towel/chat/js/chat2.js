var chat ={}

chat.fetchMessages = function () {
    $.ajax({
        url:'ajax/chat.php',
        type: 'post',
        data:{method:'fetch'},
        success: function(data){
            $('.chat .messages').html(data);
        }
    });
}
chat.fetchMessages();
chat.throwMessage=function(message){
    var m2=message.split(' ');
    var i =m2.length;
    var j=0;
    console.log(i);
    while(j<i){
        if(m2[j].indexOf('@')>-1){
            $.ajax({
                url:'ajax/chat.php',
                type: 'post',
                data:{method:'adduser', useradd:m2[j].replace('@','')},
                success: function(){
                    alert('request successful');
                },
                fail: function(){
                    alert('request failed');
                }
            });
            console.log(m2[j]);
        }
        j+=1;
    }
    if($.trim(message) !=0){
        $.ajax({
        url:'ajax/chat.php',
        type: 'post',
        data:{method:'throw', message: message},
        success: function(data){
            chat.fetchMessages();
            chat.entry.val('');
        }
    });
    }
    
}
chat.entry=$('.chat .entry');
chat.entry.bind('keydown',function(e){
    
    if(e.keyCode === 13 && e.shiftKey === false){
        console.log(e.keyCode);
        chat.throwMessage($(this).val());
        e.preventDefault();
    }
});

chat.interval= setInterval(chat.fetchMessages, 5000);