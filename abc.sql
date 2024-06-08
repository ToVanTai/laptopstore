select
	*
from
	order_details od
where
	od.order_id in (
	select
		o.id
	from
		orders o
	where
		o.user_id = 41);
		
	
	select
		o.id
	from
		orders o
	where
		o.user_id = 41