<?php
        function shutdown() {
            echo posix_getpid() . '::' . posix_getsid(posix_getpid()) . "\n";
            posix_kill(posix_getpid(), SIGHUP);
        }

        // Do some initial processing

        echo("Hello World\n");

        // Switch over to daemon mode.

        if ($pid = pcntl_fork()) {
            $fp1 = fopen("/tmp/foo", "w");
            fprintf($fp1, "PID = %s  SID = %s\n", posix_getpid(), posix_getsid(posix_getpid()));
            fclose($fp1);
            return;     // Parent
        }

//        ob_end_clean(); // Discard the output buffer and close

        fclose(STDIN);  // Close all of the standard
        fclose(STDOUT); // file descriptors as we
        fclose(STDERR); // are running as a daemon.

        register_shutdown_function('shutdown');

        $fp2 = fopen("/tmp/foo0", "w");
        fprintf($fp2, "PID = %s  SID = %s\n", posix_getpid(), posix_getsid(posix_getpid()));
        fclose($fp2);
        if (posix_setsid() < 0)
            return;

        $fp3 = fopen("/tmp/foo1", "w");
        fprintf($fp3, "PID = %s  SID = %s\n", posix_getpid(), posix_getsid(posix_getpid()));
        fclose($fp3);

        if ($pid = pcntl_fork()) {
            $fp4 = fopen("/tmp/foo2", "w");
            fprintf($fp4, "PID = %s  SID = %s\n", posix_getpid(), posix_getsid(posix_getpid()));
            fclose($fp4);
            return;     // Parent
        }

        // Now running as a daemon. This process will even survive
        // an apachectl stop.

        $fp5 = fopen("/tmp/foo3", "w");
        fprintf($fp5, "PID = %s  SID = %s\n", posix_getpid(), posix_getsid(posix_getpid()));
        fclose($fp5);

        sleep(20);

        return;
?>
