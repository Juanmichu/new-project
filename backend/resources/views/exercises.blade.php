<table class="min-w-full bg-white">
	<thead>
	<tr class="bg-gray-200">
		<th class="py-2 px-4">Exercise</th>
		<th class="py-2 px-4">Muscle Group</th>
	</tr>
	</thead>
	<tbody>
	@foreach ($exercises as $exercise)
		<tr class="border-b">
			<td class="py-2 px-4">{{ $exercise->name }}</td>
			<td class="py-2 px-4">{{ $exercise->muscle_group }}</td>
		</tr>
	@endforeach
	</tbody>
</table>
