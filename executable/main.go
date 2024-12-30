package main

import (
	"bufio"
	"fmt"
	"log"
	"os"
	"os/exec"
	"path/filepath"
	"strings"

	"github.com/toqueteos/webbrowser"
)

func main() {
	path, err := os.Executable()
	if err != nil {
		log.Fatalf("Path Error: %s", err)
	}

	dir, _ := filepath.Split(path)
	dir, _ = filepath.Split(dir[:len(dir)-1])

	err = os.Chdir(dir)
	if err != nil {
		log.Fatalf("Chdir Error: %s", err)
	}

	dir, _ = os.Getwd()
	fmt.Printf("Current Directory: %s\n", dir)

	cmd := exec.Command("php", "artisan", "serve")
	fmt.Printf("Running: %s\n", cmd.Args)
	fmt.Println("Your POINT OF SALES SYSTEM is running!")

	hostchannel := make(chan string)
	dupchannel := make(chan bool)

	go func() {
		stream, err := cmd.StdoutPipe()

		cmd.Start()

		if err != nil {
			log.Fatal(err)
		}

		scanner := bufio.NewScanner(stream)
		for scanner.Scan() {
			text := scanner.Text()
			if strings.Contains(text, "Server running on") {
				endpoint := strings.Split(text, "http://")[1]
				endpoint = endpoint[:len(endpoint)-4]

				if port := strings.Split(endpoint, ":")[1]; port != "8000" {
					fmt.Println("POS Already running, opening that instance instead!")

					hostchannel <- "127.0.0.1:8000"
					dupchannel <- true
					break
				}

				fmt.Println(endpoint)

				hostchannel <- endpoint
				dupchannel <- false
			}
		}
	}()

	host := <-hostchannel
	dup := <-dupchannel

	webbrowser.Open(fmt.Sprintf("http://%s", host))

	if dup {
		// pgid, err := syscall.Getpgid(cmd.Process.Pid)
		//       if err != nil {
		//           log.Fatal(err)
		//       }
		//
		//       syscall.Kill(-pgid, 15)
		//       fmt.Println("Process Killed")

        cmd.Wait()
	} else {
		cmd.Wait()
	}

}
