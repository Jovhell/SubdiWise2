<?= partial('head', ['title' => $title]) ?>
<?= style($style) ?>

<div class="post-container">
    <div class="modal-overlay"></div>
    <div class="edit-post-modal modal">
        <div class="modal-header">
            <div class="modal-cancel">Cancel</div>
            <div class="modal-title">Edit Post</div>
        </div>
        <div class="modal-content">
            <form action="/editpost" method="POST">
                <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
                <div class="textarea">
                    <a href="/" class="display-picture">
                        <img src="<?= profile_pic($current_user['profile_picture']) ?>" alt="Profile">
                    </a>
                    <textarea name="edited-post-content" id="edit-post-content" placeholder="Edit post" required
                    ><?= $post['content'] ?></textarea>
                    <?php require('assets/Emoji_Icon.svg') ?>
                </div>
                <button>Save</button>
            </form>
        </div>
    </div>
    <div class="post">
        <div class="post-menu">
            <?php if($post['user_id'] == $current_user['id']): ?>
                <div class="post-option edit">Edit</div>
            <?php endif ?>
    
            <hr class="separator"></hr>
    
            <div class="post-option save">Save Post</div>
            <div class="post-option pin">Pin to profile</div>
            <div class="post-option hide">Hide like and share counts</div>
            <div class="post-option feature">Add to featured</div>
    
            <hr class="separator"></hr>
    
            <?php if($post['user_id'] == $current_user['id']): ?>
                <div class="post-option delete">
                    <form action="/deletepost" method="POST">
                        <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
                        <input type="submit" style="display: none" id="delete-btn-<?= $post['post_id'] ?>">
                        <label for="delete-btn-<?= $post['post_id'] ?>">Delete</label>
                    </form>
                </div>
            <?php endif ?>
    
            <hr class="separator"></hr>
    
            <div class="post-option copy" onClick="navigator.clipboard.writeText(`${window.location.origin}/<?= $post['user_id'] . "/post/" . $post['user_id']?>`)">Copy link</div>
        </div>
        <div class="display-picture">
            <img src="<?= profile_pic($post['profile_picture']) ?>" alt="">
        </div>
        <div class="content">
            <div class="post-header">
                <div class="name">
                    <?= $post['fname'] . ' ' . $post['lname'] ?>
                </div>
                ·
                <div class="time">
                    <?= timeAgo($post['created_at']) ?>
                </div>
                ·
                <div class="privacy">
                    <?php require('assets/'.($post['privacy'] == 'public' ? 'Public' : 'Private').'_Icon.svg') ?>
                </div>
                <div class="meatball">
                    <?php require('assets/Meatball_Icon.svg') ?>
                </div>
            </div>
            <div class="context">
                <div class="text">
                    <?= nl2br($post['content']) ?>
                </div>
                <div class="attachments">
                    <?php foreach(json_decode($post['images']) as $image): ?>
                        <div class="attachment">
                            <img src="uploads/<?= $image ?>" >
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="datas">
                <div class="data like <?= in_array($post['post_id'], $liked_posts) ? 'filled' : '' ?>"
                    data-post-id="<?= $post['post_id'] ?>"
                    data-is-dislike="<?= in_array($post['post_id'], $liked_posts) ? 1 : 0?>"
                    data-count="<?= $post['likes_count'] < 0 ? 0 : $post['likes_count'] ?>"    
                >
                    <?php require('assets/Heart_Icon.svg') ?>
                    <span><?php echo $post['likes_count'] > 0 ? $post['likes_count'] : '' ?></span>
                </div>
                <div class="data">
                    <?php require('assets/Comment_Icon.svg') ?>
                    <?php echo $post['comments_count'] > 0 ? $post['likes_count'] : '' ?>
                </div>
                <div class="data">
                    <?php require('assets/Share_Icon.svg') ?>
                    <?php echo $post['shares_count'] > 0 ? $post['likes_count'] : '' ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= script('post')?>
<?= partial('foot') ?>