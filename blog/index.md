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

<nav>
	<ul class="pager">
{% if page.previous.url %}
	<li><a href="{{page.previous.url}}" title="Previous Post: {{page.previous.title}}"><i class="icon-chevron-left"></i> Previous</a></li>
{% else %}
	<li class="disabled"><a href="#"><i class="icon-chevron-left"></i> Previous</a></li>
{% endif %}
{% if page.next.url %}
	<li><a href="{{page.next.url}}" title="Next Post: {{page.next.title}}"><i class="icon-chevron-right"></i> Next</a></li>
{% else %}
	<li class="disabled"><a href="#"><i class="icon-chevron-right"></i> Next</a></li>
{% endif %}
	</ul>
</nav>
