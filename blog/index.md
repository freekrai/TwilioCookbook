---
title: Blog
author: Roger Stringer
layout: page
---

<div class="posts">
	{% for post in paginator.posts %}
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

<nav>
	<ul class="pager">
	{% if paginator.next_page %}
		<li><a href="{{ site.baseurl }}page{{paginator.next_page}}">Older</a></li>
	{% else %}
		<li>Older</li>
	{% endif %}
	{% if paginator.previous_page %}
		{% if paginator.page == 2 %}
			<li><a href="{{ site.baseurl }}">Newer</a></li>
		{% else %}
			<li><a href="{{ site.baseurl }}page{{paginator.previous_page}}">Newer</a></li>
		{% endif %}
	{% else %}
		<li>Newer</li>
	{% endif %}
	</ul>
</nav>
