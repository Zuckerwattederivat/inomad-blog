<!-- posts table -->
<table id="posts-table" class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Author</th>
      <th>Title</th>
      <th>Category</th>
      <th>Tags</th>
      <th>Status</th>
      <th>Image</th>
      <th>Content</th>
      <th>Date</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data['posts'] as $post) : ?>
      <tr>
        <td><?php echo $post->post_id; ?></td>
        <td><?php echo $post->user_alias; ?></td>
        <td><?php echo $post->post_title; ?></td>
        <td><?php echo $post->cat_title; ?></td>
        <td><?php echo $post->post_tags; ?></td>
        <td><?php echo $post->post_status; ?></td>
        <td><img src='<?php echo URLROOT . "/img/posts/thumb_" . $post->post_image; ?>' class='img-thumb' style='width: 100px' alt="<?php echo $post->post_image; ?>"></td>
        <td><?php echo substrwords($post->post_content, 50); ?></td>
        <td><?php echo $post->post_date; ?></td>
        <td class="text-center"><a class=" btn btn-info" href="<?php echo URLROOT . "/admin/edit_post/".$post->post_id; ?>"><i class="fa fa-edit"></i></a></td>
        <td class="text-center"><a href="#confirm-delete" class="btn btn-danger" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="window.history.pushState({}, null, '<?php echo URLROOT.'/admin/delete_post/'.$post->post_id; ?>');"><i class="fa fa-trash"></i></a></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<!-- /. posts table -->

<!-- Posts Table Script -->
<script type="text/javascript" src="<?php echo URLROOT; ?>/js_cms/posts_table.js"></script>