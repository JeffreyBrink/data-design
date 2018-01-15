<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<title>Data-Design</title>
	</head>
	<body>
		<h1>Persona</h1>
		<h2>Ted Random

			Male, age 25</h2>
		<h2> tech usage:
			<br>uses a pc desktop to produce music for his band
			<br>uses a pc laptop to record live at gigs/events.
			<br>spends alot of time writing/reading medium's music content.</h2>
		<h2>User story:
			<br>Ted likes to contribute to the site, as well as be informed by others on the site as well.</h2>
		<h2>use case:
			Ted posted his new blog on the most sought after Fender Stratacaster.
			<br>Later in the day, he checks back
			and sees he has recieved twenty seven claps.</h2>
		<h2>precondition: Ted is a user in good standing on the site.
			<br>postcondition: Ted feels great that people liked his blog post.
		</h2>
		<h2>Interaction flow:</h2>
		<ul>
			<li>Ted logs into his account---site gives him user account page</li>
			<li>Ted clicks the button to create a blog post---site gives him create new post page</li>
			<li>Ted writes his blog post---site is ambivalent</li>
			<li>Ted clicks button to post his new blog---site posts new blog</li>
			<li>Ted logs out--site shows you are logged off page</li>
			<li>Ted repeats process---site shows that he has recieved 274 claps</li>
			<li>Ted is happy---site forgets Ted</li>
		</ul>
		<h2>Entities and attributes</h2>
		<h2>profile</h2>
		<ul>
			<li>ProfieId (primary, uuid)</li>
			<li>activationToken</li>
			<li>profileEmail</li>
			<li>ProfilePhone</li>
			<li>profileHash</li>
			<li>profileSalt</li>
		</ul>
		<br>
		<h2>Blog</h2>
		<ul>
			<li>blogId (primary key)</li>
			<li>blogProfileId</li>
			<li>blogContent</li>
			<li>blogDate</li>
		</ul>
		<h2>Clap</h2>
		<ul>
			<li>clapId (primary key)</li>
			<li>blogId (foriegn key)</li>
			<li>profileId (foriegn key)</li>
		</ul>
		<h2>Relations</h2>
		<ul>
			<li>One profile can write many blog posts (1 to N)</li>
			<li>Blog posts can only be written by one profile M to 1)</li>
			<li>Many blogs can be clapped by many profiles (M to N)</li>
			<li>many profiles can make one clap (M to 1)</li>
		</ul>


	</body>
</html>