<?php 

ob_start();
session_Start();

//$no_navbar = '';
$pageTitle = 'Home Page';
include('init.php');

$allPosts = getAllPosts('DESC');
$allComments = getAllComments('DESC');
$allCategories = getAllCategories();
//$post = getLatestPosts('*', 'post', 'post_date', $count = 1);
//$allCommentsForPost = getAllCommentsForPost('ASC' , $post[0]['post_id']);

if (isset($_SESSION['username'])) {
    /**
     * header('Location: profile.php');
     * exit();
     */
} else { ?>
<div class="comments-wrapper">
                
                <div id="comments" class="mt-5">
                    
                    
                    
                    <h2>5 Comments</h2>
                
                    <ul class="medias py-md-5 my-md-5 px-sm-0">
                    
                            
                        <li id="comment-12" class="comment byuser comment-author-aymene bypostauthor even thread-even depth-1 has-children bubble bubble-primary list-unstyled xxx">
                            <div class="wrapper">
                                <div class="avatar">
                                                    <a data-toggle="tooltip" data-placement="left" data-html="true" title="" href="" class="media-object float-left" data-original-title="aymene">
                                            <img alt="" src="http://2.gravatar.com/avatar/b6561d0be578435f47a56259df19ffc0?s=40&amp;d=mm&amp;r=g" srcset="http://2.gravatar.com/avatar/b6561d0be578435f47a56259df19ffc0?s=80&amp;d=mm&amp;r=g 2x" class="avatar avatar-40 photo comment_avatar rounded-circle" height="40" width="40">						</a>
                                                    </div>
                            
                            <div id="div-comment-12" class="comment-self left">
                                <p class="messenger-bulle hoverable">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<span class="meta">2 April 2017, 14 h 06 min</span>
                                    </p>
                                    <div class="reply btn btn-rounded btn-secondary text-muted waves-effect waves-light"><i class="icon-action-undo"></i></div>				
                            </div>
                            
                            </div>
                                        
                                
                
                            
                <ul class="children">
                        
                        <li id="comment-13" class="comment byuser comment-author-aymene bypostauthor odd alt depth-2  bubble bubble-secondary list-unstyled yyy">
                            <div class="wrapper">
                                <div class="avatar">
                                                    <a data-toggle="tooltip" data-placement="right" data-html="true" title="" href="" class="media-object float-left" data-original-title="aymene">
                                            <img alt="" src="http://2.gravatar.com/avatar/b6561d0be578435f47a56259df19ffc0?s=40&amp;d=mm&amp;r=g" srcset="http://2.gravatar.com/avatar/b6561d0be578435f47a56259df19ffc0?s=80&amp;d=mm&amp;r=g 2x" class="avatar avatar-40 photo comment_avatar rounded-circle" height="40" width="40">						</a>
                                                    </div>
                            
                            <div id="div-comment-13" class="comment-self right">
                                <div class="reply btn btn-rounded btn-secondary text-muted waves-effect waves-light"><i class="icon-action-redo"></i></div>
                                    <p class="messenger-bulle hoverable">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<span class="meta">2 April 2017, 14 h 31 min</span>
                                    </p>
                                                    
                            </div>
                            
                            </div>
                                        
                                
                
                            <!-- </div>		 -->
                </li><!-- #comment-## -->
                </ul>
                </li>
                        
                        
                        
                        <li id="comment-15" class="comment byuser comment-author-aymene bypostauthor odd alt thread-even depth-1  bubble bubble-secondary list-unstyled yyy">
                            <div class="wrapper">
                                <div class="avatar">
                                                    <a data-toggle="tooltip" data-placement="left" data-html="true" title="" href="" class="media-object float-left" data-original-title="aymene">
                                            <img alt="" src="http://2.gravatar.com/avatar/b6561d0be578435f47a56259df19ffc0?s=40&amp;d=mm&amp;r=g" srcset="http://2.gravatar.com/avatar/b6561d0be578435f47a56259df19ffc0?s=80&amp;d=mm&amp;r=g 2x" class="avatar avatar-40 photo comment_avatar rounded-circle" height="40" width="40">						</a>
                                                    </div>
                            
                            <div id="div-comment-15" class="comment-self left">
                                <p class="messenger-bulle hoverable">blibli bli bli bli haha x) :D<span class="meta">2 April 2017, 17 h 57 min</span>
                                    </p>
                                    <div class="reply btn btn-rounded btn-secondary text-muted waves-effect waves-light"><i class="icon-action-undo"></i></div>				
                            </div>
                            
                            </div>
                                        
                                
                
                            <!-- </div>		 -->
                </li>
                        
                        
                    </ul>
                
                
                
                <div class="col-md-6 offset-md-3">
                    <button class="btn btn-lg btn-block gradient waves-effect waves-light" data-toggle="modal" data-target="#modal-comment">Comment now</button>
                </div>
                <div class="modal fade" id="modal-comment" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content p-5">
                            <div id="respond" class="comment-respond">
                        <h3 id="reply-title" class="comment-reply-title">Leave a Reply <small><a rel="nofollow" id="cancel-comment-reply-link" href="/boopress/2017/03/27/article-avec-hero-image/#respond" style="display:none;">Cancel reply</a></small></h3>			<form action="http://wordpress/boopress/wp-comments-post.php" method="post" id="commentform" class="comment-form" name="commentForm" onsubmit="return validateForm();">
                                <p class="logged-in-as"><a href="http://wordpress/boopress/wp-admin/profile.php" aria-label="Logged in as aymene. Edit your profile.">Logged in as aymene</a>. <a href="http://wordpress/boopress/wp-login.php?action=logout&amp;redirect_to=http%3A%2F%2Fwordpress%2Fboopress%2F2017%2F03%2F27%2Farticle-avec-hero-image%2F&amp;_wpnonce=96f83bad6e">Log out?</a></p><div class="form-group"><label for="comment">Comment</label><span>*</span><textarea id="comment" class="form-control" name="comment" rows="3" aria-required="true"></textarea><p id="d3" class="text-danger"></p></div><p class="form-submit"><i class="btn waves-effect btn-block btn-outline-primary btn-sm waves-input-wrapper"><input name="submit" type="submit" id="submit" class="waves-button-input" value="Post Comment"></i> <input type="hidden" name="comment_post_ID" value="166" id="comment_post_ID">
                <input type="hidden" name="comment_parent" id="comment_parent" value="0">
                </p><input type="hidden" id="_wp_unfiltered_html_comment_disabled" name="_wp_unfiltered_html_comment" value="25d32b07a2"><script>(function(){if(window===window.parent){document.getElementById('_wp_unfiltered_html_comment_disabled').name='_wp_unfiltered_html_comment';}})();</script>
                            </form>
                            </div><!-- #respond -->
                        
                    <script>
                            /* basic javascript form validation */
                            function validateForm() {
                            var form    =  document.forms["commentForm"];
                                x       = form["author"].value,
                                y       = form["email"].value,
                                z       = form["comment"].value,
                                flag    = true,
                                d1      = document.getElementById("d1"),
                                d2      = document.getElementById("d2"),
                                d3      = document.getElementById("d3");
                                
                            if (x == null || x == "") {
                                d1.innerHTML = "Name is required";
                                z = false;
                            } else {
                                d1.innerHTML = "";
                            }
                            if (y == null || y == "") {
                                d2.innerHTML = "Email is required";
                                z = false;
                            } else {
                                d2.innerHTML = "";
                            }
                            if (z == null || z == "") {
                                d3.innerHTML = "Comment is required";
                                z = false;
                            } else {
                                d3.innerHTML = "";
                            }
                            if (z == false) {
                                return false;
                            }
                        }
                    </script>
                      
                    </div>
                  </div>
                </div>
                    
                </div><!-- #comments -->            </div>

<?php } ?>


<?php
include($templates . 'footer.php');
ob_end_flush();
?>