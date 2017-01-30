	<?php render($comments); ?>

	<?php function render($comments, $parent = null){  ?>
	
		<?php foreach ($comments as $key => $comment) { ?>
				
			<?php if($comment->parent_id == $parent){ ?>

			<div class="media" id="<?php echo $comment->id ?>">
				<div class="media-left">
				    <img class="media-object img-rounded" height="50px" src="https://randomuser.me/api/portraits/men/<?php echo $comment->user_id ?>.jpg">
				</div>
				<div class="media-body">
					<div class="panel panel-primary">

						<div class="panel-heading">
							<div class="author"><?php echo $comment->user_name ?></div>
							<div class="metadata">
								<span class="date"><?php echo date('d.m.y H:i', strtotime($comment->created_at)) ?></span>
							</div>          
						</div>

						<?php if($comment->deleted_at) { ?>

						<div class="panel-body">
							<div class="media-text text-justify text-danger">Коментар було видалено</div>
						</div>

						<?php } else { ?>

						<div class="panel-body">
							<div class="media-text text-justify"><?php echo $comment->body ?></div>
						</div>

						<div class="panel-footer" data-id="<?php echo $comment->id ?>">
							<span class="vote plus js-vote" title="Подобається" data-value="+1">
								<i class="fa fa-thumbs-up"></i>
							</span>       
							<span class="rating">
								<?php echo $comment->votes ?> 
							</span>
							<span class="vote minus js-vote" title="Не подобається" data-value="-1">
								<i class="fa fa-thumbs-down"></i>
							</span>
							<span class="devide">
							 	|
							</span>
							
							<?php if(AuthController::user() && $comment->user_id == AuthController::user()->id){ ?>
								<a class="btn btn-xs btn-warning js-edit" href="#" data-id="<?php echo $comment->id ?>">Редагувати</a>
								<a class="btn btn-xs btn-danger js-delete" href="#" data-id="<?php echo $comment->id ?>">Видалити</a>
							<?php } else { ?>
								<a class="btn btn-xs btn-primary js-reply" 
									href="#" data-id="<?php echo $comment->id ?>">Відповісти</a>
							<?php } ?>
						</div>
						<?php } ?>
					</div>	

						<?php unset($comments[$key]); ?>

						<?php render($comments, $comment->id); ?>

				</div>
			</div>
			<?php } ?>
		<?php } ?>
	<?php }  ?>