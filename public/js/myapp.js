var postId = 0;
var postBodyElement = null;

$('.post').find('.interaction').find('.edit').on('click', function (event) {  
    event.preventDefault();

    //get up level to article tag with class post and then get the first child node text content
    postBodyElement = event.target.parentNode.parentNode.childNodes[1];
    var postBody = postBodyElement.textContent;

    postId = event.target.parentNode.parentNode.dataset['postid'];
    // insert value of the first child not text content into textarea
    $('#post-body').val(postBody);
    // show modal edit-modal 
    $('#edit-modal').modal();
});

$('#save-modal').on('click', function(){
    $.ajax({
        method: 'POST',
        url: urlEdit,
        data: {
            body: $('#post-body').val(),
            postId: postId,
            _token: token
        }
    }).done(function(msg){
        $(postBodyElement).text(msg['new_body']);
        $('#edit-modal').modal('hide');
    });
});

$('.like').on('click', function(event){
    // check if the element have previous sibling (previous element before it) or not
    var isLike = event.target.previousElementSibling == null;
    postId = event.target.parentNode.parentNode.dataset['postid'];
    $.ajax({
        method: 'POST',
        url: urlLike,
        data: { isLike: isLike, postId: postId, _token: token}
    }).done(function(){
        // Change the page
        event.target.innerText = isLike ? event.target.innerText == 'Like' ? 'You like this post' : 'Like' : event.target.innerText == 'Dislike' ? 'You don\'t like this post' : 'Dislike';
        if(isLike){
            event.target.nextElementSibling.innerText = 'Dislike';
        } else{
            event.target.previousElementSibling.innerText = 'Like';
        }
    });
});