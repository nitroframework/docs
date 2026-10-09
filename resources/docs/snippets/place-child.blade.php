@foreach ($questions as $i => $item)
    <nitro:faq-item :question="$item['question']" :answer="$item['answer']" :key="$i" />
@endforeach
