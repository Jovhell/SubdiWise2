<div class="header">
    <h2>Feed</h2>
    <a href="?feed=following">Following</a>
    <a class="active" href="/">Recents</a>
</div>
<form action="/post" method="POST" enctype="multipart/form-data">
    <div class="create-post">
        <div class="textarea">
            <a href="/" class="display-picture">
                <img src="<?= profile_pic($current_user['profile_picture']) ?>" alt="Profile">
            </a>
            <textarea name="post-content" id="post-content" placeholder="Share news, updates, or events..." required></textarea>
            <?php require('assets/Emoji_Icon.svg') ?>
        </div>
        
        <div class="options">
            <label class="option">
                <img src="assets/File_Icon.svg" alt="File"> File
                <input type="file" name="file" id="file" hidden>
            </label>

            <label class="option">
                <img src="assets/Image_Icon.svg" alt="Image"> Image
                <input type="file" name="image" id="image" accept="image/*" hidden>
            </label>

            <div class="custom-dropdown">
                <div class="dropdown-selected option" id="selected-privacy" data-value="public">
                    <img id="privacy-icon" src="assets/Public_Icon.svg" alt="">
                    <span>Public</span>
                    <img class="arrow" src="assets/Dropdown_Icon.svg" alt="▼">
                </div>
                <ul class="dropdown-options">
                    <li data-value="public">Public</li>
                    <li data-value="private">Private</li>
                </ul>
                <input type="hidden" name="privacy" id="privacy" value="public">
            </div>

            <!-- Post Button -->
            <button type="submit" class="post-button">Post</button>
        </div>
    </div>
</form>

<?php foreach ($posts as $post): ?>
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
            <div class="post-option save">Save Post</div>
            <?php if($post['user_id'] == $current_user['id']): ?>
                <div class="post-option delete">
                    <form action="/deletepost" method="POST">
                        <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
                        <input type="submit" style="display: none" id="delete-btn-<?= $post['post_id'] ?>">
                        <label for="delete-btn-<?= $post['post_id'] ?>">Delete</label>
                    </form>
                </div>
            <?php endif ?>
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
                    <?= $post['content'] ?>
                </div>
                <div class="attachments">

                </div>
            </div>
            <div class="datas">
                <form action="/likepost" method="POST">
                    <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
                    <input type="hidden" name="isDislike" value="<?= in_array($post['post_id'], $liked_posts) ?>">
                    <button type="submit" id="submit_<?= $post['post_id']?>" style="display:none"></button>
                    <label for="submit_<?= $post['post_id']?>" class="data <?= in_array($post['post_id'], $liked_posts) ? 'filled' : '' ?>">
                        <?php require('assets/Heart_Icon.svg') ?>
                        <?php echo $post['likes_count'] > 0 ? $post['likes_count'] : '' ?>
                    </label>
                </form>
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
<?php endforeach; ?>