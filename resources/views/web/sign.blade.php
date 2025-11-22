<h2>Sign Agreement (Project #{{ $project->id }})</h2>

<iframe id="signFrame" style="width:100%;height:800px;border:0;"></iframe>

<script>
fetch("/projects/{{ $project->id }}/agreement/sign-link")
    .then(res => res.json())
    .then(data => {
        document.getElementById("signFrame").src = data.signingUrl;
    });
</script>
