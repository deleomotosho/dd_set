
<h3> Analysis </h3>
<hr/>

<table>
    <thead>
    <tr>
        <td>Ad ID</td>
        <td>All-time Total Views</td>
        <td>All-time Click Through Rate %</td>
        <td>All-time Conversion Rate %</td>
        <td>All-time Total revenue</td>
        <td>All-time Average Customer Age (for leads that clicked the ad)</td>
        <td>All-time Best State (State with the most conversions)</td>
        <td>All-time Worst State (State with the least conversions)</td>
    </tr>
    </thead>

    <tbody>
    @foreach($analysis as $row)
        <tr>
            <td>{{ $row->id }}</td>
            <td>{{ number_format($row->totalViews) }}</td>
            <td>{{ round($row->ctr , 2) }} %</td>
            <td>{{ round($row->cvRate  * 100,2) }}%</td>
            <td>${{ number_format($row->totalRevenue) }}</td>
            <td>{{ $row->averageAge }} years old</td>
            <td>{{ $row->bestState }}</td>
            <td>{{ $row->worstState }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
