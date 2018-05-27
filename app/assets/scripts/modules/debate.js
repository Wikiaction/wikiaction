
function edit_content(edit_id,content_id){
	document.getElementById(edit_id).style.display = "block";
	document.getElementById(content_id).style.display = "none";
}
function hide_edit(edit_id,content_id){
	document.getElementById(edit_id).style.display = "none";
	document.getElementById(content_id).style.display = "block";
}

function reply_to_post(reply_id){
	document.getElementById(reply_id).style.display = "block";
}
function hide_reply(reply_id){
	document.getElementById(reply_id).style.display = "none";
}

function approve(post_id,user_id){
  var postID = document.getElementById(post_id);
  if (postID.getElementsByClassName("arrowup")[0].classList.contains('voted')){
    postID.getElementsByClassName("approved")[0].style.display = "none";
    postID.getElementsByClassName("neutral")[0].style.display = "block";
    postID.getElementsByClassName("disapproved")[0].style.display = "none";
    postID.getElementsByClassName("arrowup")[0].classList.remove('voted');
    vote(post_id,0);
  }
  else if (postID.getElementsByClassName("arrowdown")[0].classList.contains('voted')){
    postID.getElementsByClassName("approved")[0].style.display = "block";
    postID.getElementsByClassName("neutral")[0].style.display = "none";
    postID.getElementsByClassName("disapproved")[0].style.display = "none";
    postID.getElementsByClassName("arrowdown")[0].classList.remove('voted');
		postID.getElementsByClassName("arrowup")[0].classList.add('voted');
    vote(post_id,1);
  }
  else {
    postID.getElementsByClassName("approved")[0].style.display = "block";
    postID.getElementsByClassName("neutral")[0].style.display = "none";
    postID.getElementsByClassName("arrowup")[0].classList.add('voted');
    vote(post_id,1);
  }
}

function disapprove(post_id,user_id){
  var postID = document.getElementById(post_id);
  if (postID.getElementsByClassName("arrowdown")[0].classList.contains('voted')){
    postID.getElementsByClassName("approved")[0].style.display = "none";
    postID.getElementsByClassName("neutral")[0].style.display = "block";
    postID.getElementsByClassName("disapproved")[0].style.display = "none";
    postID.getElementsByClassName("arrowdown")[0].classList.remove('voted');
    vote(post_id,0);
  }
  else if (postID.getElementsByClassName("arrowup")[0].classList.contains('voted')){
    postID.getElementsByClassName("approved")[0].style.display = "none";
    postID.getElementsByClassName("neutral")[0].style.display = "none";
    postID.getElementsByClassName("disapproved")[0].style.display = "block";
    postID.getElementsByClassName("arrowup")[0].classList.remove('voted');
		postID.getElementsByClassName("arrowdown")[0].classList.add('voted');
    vote(post_id,-1);
  }
  else {
    postID.getElementsByClassName("disapproved")[0].style.display = "block";
    postID.getElementsByClassName("neutral")[0].style.display = "none";
    postID.getElementsByClassName("arrowdown")[0].classList.add('voted');
    vote(post_id,-1);
  }
}

function vote(Post_ID, VoteValue){
   $.ajax({
      url: 'vote.php',
      type: 'POST',
      data: {post_id: Post_ID, value: VoteValue}
   })
   .done(function() {
     alert( "Vote Saved");
    });
}


// TAG REMOVER JS
var tagBody = '(?:[^"\'>]|"[^"]*"|\'[^\']*\')*';

var tagOrComment = new RegExp(
    '<(?:'
    // Comment body.
    + '!--(?:(?:-*[^->])*--+|-?)'
    // Special "raw text" elements whose content should be elided.
    + '|script\\b' + tagBody + '>[\\s\\S]*?</script\\s*'
    + '|style\\b' + tagBody + '>[\\s\\S]*?</style\\s*'
    // Regular name
    + '|/?[a-z]'
    + tagBody
    + ')>',
    'gi');
function removeTags(html) {
  var oldHtml;
  do {
    oldHtml = html;
    html = html.replace(tagOrComment, '');
  } while (html !== oldHtml);
  return html.replace(/</g, '&lt;');
}

function removeTagsSimple(html){
	return html.replace(/<(?:.|\n)*?>/gm, '');
}


// Modal Window
function showDebateModal(){
	document.getElementById("debateModal").style.display = "block";
}
