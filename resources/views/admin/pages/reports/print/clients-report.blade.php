@include('admin.pages.reports.print.header')

<table>
    <thead>
        <tr>
            <th>{{__('Name')}}</th>
			<th>{{__('Phone')}}</th>
			<th>{{__('Mobile')}}</th>
			<th>{{__('Country')}}</th>
			<th>{{__('Area')}}</th>
			<th>{{__('City')}}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data['clients'] as $client)
            <tr>
                <td>{{ $client->name }}</td>
                <td>{{ $client->phone }}</td>
                <td>{{ $client->mobile }}</td>
                <td>{{ $client->country }}</td>
                <td>{{ $client->area }}</td>
                <td>{{ $client->city }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">{{ __('No Data Found.') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>

@include('admin.pages.reports.print.footer')
