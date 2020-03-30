<script type="text/html" id="cldr-template">

	<div class="clndr">
		<div class="c-clndr-controls">
			<div class="c-clndr-controls__prev">&lsaquo;</div>
			<div class="month"><%= month %> de <%= year %></div>
			<div class="c-clndr-controls__next">&rsaquo;</div>
		</div>
		<div class="clndr-grid">
			<div class="days-of-the-week">
				<% _.each(daysOfTheWeek, function (day) { %>
				<div class="header-day"><%= day %></div>
				<% }) %>
				<div class="days">
					<% _.each(days, function (day) { %>
					<div class="<%= day.classes %>"><%= day.day %></div>
					<% }) %>
				</div>
			</div>
		</div>
	</div>

</script>