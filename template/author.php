<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
$userId = get_query_var('author');
$user = get_user_by('ID', $userId);
$userMeta = ue_get_user_meta($userId);

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?= get_avatar( $userId); ?>
			<table>
				<tbody>
					<tr>
						<th>Имя: </th>
						<td><?= $user->display_name; ?></td>
					</tr>
					<tr>
						<th>Пол: </th>
						<td><?= $userMeta['user_sex']; ?></td>
					</tr>
					<tr>
						<th>Семейный статус: </th>
						<td><?= $userMeta['user_family']; ?></td>
					</tr>
					<tr>
						<th>Email: </th>
						<td><?= $user->user_email; ?></td>
					</tr>
					<tr>
						<th>Адрес: </th>
						<td><?= $userMeta['user_adress']; ?></td>
					</tr>
					<tr>
						<th>Телефон: </th>
						<td><?= $userMeta['user_telephone']; ?></td>
					</tr>
					<tr>
						<th>Дата регистрации: </th>
						<td><?= $user->user_registered; ?></td>
					</tr>
				</tbody>
			</table>
		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php
get_footer();
