<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Nuevo pedido</title>
</head>
<body>
	<p>Se ha realizado huevo pedido</p>
	<p>Estos son los datos del cliente que realizo el pedido:</p>
	<ul>
		<li>
			<strong>Nombre:</strong>
			{{$user->name}}
		</li>
		<li>
			<strong>Email:</strong>
			{{$user->email}}
		</li>
		<li>
			<strong>Fecha del pedido:</strong>
			{{$cart->order_date}}
		</li>
	</ul>
	<hr>

	<p>Y estos son los detalles de pedido</p>
	<ul>
		@foreach($cart->details as $detail)
		<li>
			{{ $detail->product->name}} x {{ $detail->quantity}} 
			($ {{$detail->cuantity * $detail->product->price}})
		</li>
		@endforeach
	</ul>
	<p>
		<strong>Importe que el cliente debe pagar:</strong> {{ $cart->total }}
	</p>
	<p>
		<a href="{{url('/admin/orders/'.$cart->id)}}">Haz clic aqui</a>
		Para ver mas informacion sobre este pedido.
	</p>
</body>
</html>