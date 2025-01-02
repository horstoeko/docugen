<?php

if (!function_exists('str_starts_with')) {
    function str_starts_with(string $haystack, string $needle): bool
    {
        return $needle === '' || strpos($haystack, $needle) === 0;
    }
}

if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle)
    {
        return (strpos($haystack, (string) $needle) !== false);
    }
}

if (!function_exists('str_ends_with')) {
    function str_ends_with(string $haystack, string $needle): bool
    {
        return $needle === '' || substr($haystack, -strlen($needle)) === $needle;
    }
}

function stricontains(string $haystack, string $needle): bool
{
    return str_contains(strtolower($haystack), strtolower($needle));
}

function stristartswith(string $haystack, string $needle): bool
{
    return str_starts_with(strtolower($haystack), strtolower($needle));
}

function correctAuthor(string $author): string
{
    if ($author === "horstoeko") {
        $author = "HorstOeko";
    }

    return $author;
}

function correctSubject(string $commitSubject, ?array &$issues): string
{
    $issues = [];

    if (preg_match_all('/#\d+\b/', $commitSubject, $matches)) {
        $issues = array_unique($matches[0]);
    }

    foreach ($issues as $issue) {
        $commitSubject = str_replace($issue, '', $commitSubject);
    }

    if (str_starts_with($commitSubject, 'Merge pull request')) {
        $commitSubject = 'Merged PR';
    }

    return trim($commitSubject);
}

function mustHideCommit(?string $commitHash = "", ?string $commitAuthor = "", ?string $commitDate = "", ?string $commitSubject = ""): bool
{
    if (!$commitSubject) {
        return true;
    }

    return stricontains($commitSubject, '[CS]') ||
    stricontains($commitSubject, '[DOC]') ||
    stricontains($commitSubject, '[INFR]');
}

function getMarkDown($prevTag, $currTag)
{
    $markDown = [];

    echo sprintf('Getting commits from %s to %s', $prevTag, $currTag) . PHP_EOL;

    $commitStr = shell_exec(sprintf('git log --oneline --format="%%h|%%an|%%ad|%%s" "%s..%s"', $prevTag, $currTag));

    if (is_null($commitStr) || $commitStr === false) {
        return $markDown;
    }

    $commits = array_filter(explode("\n", trim($commitStr)));

    if ($commits === []) {
        return $markDown;
    }

    $noOfHiddenCommits = 0;

    $commits = array_filter($commits, function ($commit) use (&$noOfHiddenCommits) {
        [$commitHash, $commitAuthor, $commitDate, $commitSubject] = explode("|", $commit);
        $hidden = mustHideCommit($commitHash, $commitAuthor, $commitDate, $commitSubject);
        if ($hidden) {
            $noOfHiddenCommits++;
        }

        return !$hidden;
    });

    $markDown[] = sprintf('## %s', $currTag);
    $markDown[] = '';

    if ($commits !== []) {
        $markDown[] = sprintf('``Previous version %s``', $prevTag);
        $markDown[] = '';
        $markDown[] = '| Type | Hash    | Date    | Author  | Subject  | Issue(s)';
        $markDown[] = '| :--- | :------ | :------ | :------ | :------- | :-----------: ';

        foreach ($commits as $commit) {
            [$commitHash, $commitAuthor, $commitDate, $commitSubject] = explode("|", $commit);

            if (mustHideCommit($commitHash, $commitAuthor, $commitDate, $commitSubject)) {
                $noOfHiddenCommits++;
                continue;
            }

            $time = (new \DateTime())->setTimeStamp(strtotime($commitDate))->setTimezone(new DateTimeZone('Europe/Berlin'));

            $commitDate = $time->format('Y-m-d H:i:s T');
            $commitAuthor = correctAuthor($commitAuthor);
            $commitSubject = correctSubject($commitSubject, $commitIssues);
            $commitIssuesWithUrls = array_map(function ($issue) {
                return sprintf('[%1$s](https://github.com/horstoeko/docugen/issues/%2$s)', $issue, substr($issue, 1));
            }, $commitIssues);

            $commitSubjectIcons = "";
            $commitSubjectIcons .= str_starts_with($commitSubject, '[ENH] ') ? ':new: ' : '';
            $commitSubjectIcons .= str_starts_with($commitSubject, '[DEPR] ') ? ':closed_book: ' : '';
            $commitSubjectIcons .= str_starts_with($commitSubject, '[FIX] ') ? ':bug: ' : '';
            $commitSubjectIcons .= str_starts_with($commitSubject, '[FEAT] ') ? ':new: ' : '';

            $commitSubjectIcons .= ($commitSubjectIcons === "" ? ':new_moon: ' : '');

            $markDown[] = sprintf('| %6$s | [%1$s](https://github.com/horstoeko/docugen/commit/%1$s) | %2$s | %3$s | %4$s | %5$s', $commitHash, $commitDate, $commitAuthor, $commitSubject, implode(", ", $commitIssuesWithUrls), $commitSubjectIcons);
        }

        $markDown[] = '';
    }

    if ($noOfHiddenCommits == 1) {
        $markDown[] = ":exclamation: _There is one internal commit_";
        $markDown[] = '';
    }

    if ($noOfHiddenCommits > 1) {
        $markDown[] = sprintf(":exclamation: _There are %s internal commit(s)_", $noOfHiddenCommits);
        $markDown[] = '';
    }

    return $markDown;
}

function printMarkdown(array $markDown): void
{
    foreach ($markDown as $_) {
        echo $_ . PHP_EOL;
    }
}

echo "----------------------------------------------------------------------" . PHP_EOL;
echo "---- Generating CHANGELOG.md" . PHP_EOL;
echo "----------------------------------------------------------------------" . PHP_EOL;

if (!isset($argv[1]) && !isset($argv[2])) {
    echo "No arguments found using latest and current tag" . PHP_EOL;
    $lastHash = trim(shell_exec('git rev-list --tags --skip=1 --max-count=1'));
    $prevTag = trim(shell_exec(sprintf('git describe --abbrev=0 --tags %s', $lastHash)));
    $currTag = trim(shell_exec('git describe --tags --abbrev=0'));
    echo "Found tags..." . PHP_EOL;
    echo sprintf(' - prevTag: %s', $prevTag) . PHP_EOL;
    echo sprintf(' - currTag: %s', $currTag) . PHP_EOL;
    file_put_contents(__DIR__ . '/CHANGELOG.md', implode("\n", getMarkDown($prevTag, $currTag)));
} elseif (isset($argv[1]) && $argv[1] === "all") {
    echo "All-argument was presented. Looking for all tags" . PHP_EOL;
    $completeMarkDown = [];
    $allTags = explode("\n", trim(shell_exec('git tag --sort=-creatordate')));
    $allTags = array_filter($allTags, function ($tag) {
        return str_starts_with($tag, "v0.") === false;
    });
    if ($allTags !== []) {
        echo "Found tags..." . implode(', ', $allTags) . PHP_EOL;
        foreach ($allTags as $currTagKey => $currTag) {
            if (!isset($allTags[$currTagKey + 1])) {
                continue;
            }

            $prevTag = $allTags[$currTagKey + 1];
            echo sprintf('Looking for tag %s (Previous: %s)', $currTag, $prevTag) . PHP_EOL;
            $markDown = getMarkDown($prevTag, $currTag);
            foreach ($markDown as $markDownLine) {
                $completeMarkDown[] = $markDownLine;
            }
        }

        file_put_contents(__DIR__ . '/CHANGELOG.md', implode("\n", $completeMarkDown));
    } else {
        echo "No tags were found" . PHP_EOL;
    }
} else {
    echo "First and previous tag were presented" . PHP_EOL;
    $prevTag = $argv[1];
    $currTag = $argv[2];
    echo sprintf(' - prevTag: %s', $prevTag) . PHP_EOL;
    echo sprintf(' - currTag: %s', $currTag) . PHP_EOL;
    file_put_contents(__DIR__ . '/CHANGELOG.md', implode("\n", getMarkDown($prevTag, $currTag)));
}
