---
title: Blog
author: Roger Stringer
layout: page
---

<div class="posts">
	{% for post in site.posts %}
		<div class="blog-post">
			<h2 class="blog-post-title">
			{% if post.link-url %}
				<a href="{{ post.link-url }}" class="link">{{ post.title }} <span class="link-arrow">&rarr;</span></a>
			{% else %}
				<a href="{{ site.baseurl }}{{ post.url }}">{{ post.title }}</a>
			{% endif %}
			</h2>
			<p class="blog-post-meta">
				{{ post.date | date: "%B %-d, %Y" }}  /
				<a href="{{ site.baseurl }}{{ post.url }}">permalink</a>
			</p>
			{{ post.content }}
		</div>
	{% endfor %}
</div>