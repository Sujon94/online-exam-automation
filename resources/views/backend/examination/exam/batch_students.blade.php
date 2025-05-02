@forelse($batch->approved_students as $s)
<tr>
    <td>
        <input class="to-labelauty" name="studentSelectCheck[{{ $s->student_id }}]"
               type="checkbox" id="selectYN_{{ $s->student_id }}" value="{{ $s->student_id }}"
               onclick="checkIndividual(this,{{ $s->student_id }})"/>
        <label for="selectYN_{{ $s->student_id }}"></label>
    </td>
    <td>{{$s->student->candidate_name}}</td>
    <td>{{$s->student->profession_type->type_name}}</td>
    <td>{{$s->student->mobile}}</td>
    <td></td>
</tr>
@else
    <tr>
        <td colspan="5">No student participated yet</td>
    </tr>
@endforelse