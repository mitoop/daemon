<?php
umask(0);
cli_set_process_title('daemon: master process /opt/homebrew/opt/daemon/bin/daemon');

$pid = pcntl_fork();

if (-1 === $pid) {
    throw new Exception('Fork fail');
} elseif ($pid > 0) {
    exit(0);
}

if (-1 === posix_setsid()) {
    throw new Exception("Setsid fail");
}

$pid = pcntl_fork();
if (-1 === $pid) {
    throw new Exception("Fork fail");
} elseif (0 !== $pid) {
    exit(0);
}

while (true) {
    file_put_contents('./daemon.log', "Daemon is running\n", FILE_APPEND);

    sleep(1);
}
