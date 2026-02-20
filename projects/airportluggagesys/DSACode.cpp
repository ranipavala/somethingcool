#include <iostream>
#include <iomanip>
#include <string>
#include <stack>
#include <queue>
#include <vector>
#include <unistd.h>
#include <algorithm>
#include <sys/select.h>

using namespace std;

class Luggage {
  public:
    int luggageID = 0;
    string color;
    int size;
    string Owner;
    Luggage* next;

    Luggage() {}
    Luggage(int id, string o, int s, string c) {
      this->color = c;
      this->luggageID = id;
      this->size = s;
      this->Owner = o;
    }
};

class UncollectedRoom {
    public:
        static int max_capacity;
        static int total_room;
        int room_id;
        int free_space;
        vector<Luggage> inventory;

        UncollectedRoom() {
            this->free_space = max_capacity;
            room_id = total_room;
            total_room++;
        }

        void calculateFreeSpace() {
            int total_size = 0;
            for (int i = 0; i<this->inventory.size();i++) {
                total_size += this->inventory[i].size;
            }
            this->free_space = max_capacity - total_size;
        }

        void addNewLuggage(Luggage luggage) {
            this->inventory.push_back(luggage);
            calculateFreeSpace();
        }
        
        void removeLuggage(int luggageID) {
        for (int i = 0; i < inventory.size(); ++i) {
            if (inventory[i].luggageID == luggageID) {
                inventory.erase(inventory.begin() + i);
                calculateFreeSpace(); // Recalculate free space after removing luggage
                break;
            }
        }
    }

        
};

int UncollectedRoom::max_capacity = 43200000;
int UncollectedRoom::total_room = 1;


void storeLuggage(Luggage *&head, Luggage*& tail, int id, string owner, int size, string color) {
  Luggage* n = new Luggage(id, owner, size, color);
  if (head == NULL) {
    head = tail = n;
  } else {
    tail->next = n;
    tail = n;
  }
  cout << "Luggage " << id << " has been added to the cabin successfully!\n\n\n";
}



void displayLuggage(Luggage* head) {
  cout << "\n\nLuggage in the cabin:\n";
  while (head!=NULL) {
    cout << left << setfill(' ') << setw(10) << "Luggage " << head->luggageID << " | Owner: " << head->Owner << 
    " | Color: " << head->color << "\n";
    head = head->next;
  }
}

void updateLuggageInfo(Luggage*& head) {
    int attribute = 0, id;
    Luggage *p = head;
    cout << "If any information displayed above is incorrect, enter the luggage ID [0 if no error]: ";
    cin >> id;
    if (id != 0) {
        while (p->luggageID != id) {
            p = p->next;
        }
        cout << "1. Owner Name\n2. Color\nEnter the number assigned to each attribute to make changes: ";
        cin >> attribute;
        if (attribute == 1) {
            cout << "Enter new owner name:";
            cin.ignore();
            getline(cin, p->Owner);
        } else {
            cout << "Enter new color:";
            cin >> p->color;
        }
        displayLuggage(head);
    }
    
}

void retrieveLuggage(Luggage*& head, queue<Luggage> &ready_queue) {
  Luggage* temp = NULL;
  cout << "\nRetrieving luggage now...\n";
  while (head != NULL) {
    cout << "Luggage " << head->luggageID << " removed.\n";
    ready_queue.push(*head);
    temp = head;
    head = head->next;
    free(temp);

  }
  cout << "All luggage placed into the ready queue.\n";
}



void displayLuggagePosition(queue<Luggage> ready_queue, Luggage common_space[10], UncollectedRoom uncollected_zone[], int c) {
  int counter = 0;
  cout << setfill('=') << setw(94) << "" << "\n\n" << "T-" << c << " to T-" << (c+10) << endl;
  cout << "Up next: ";
  while (!ready_queue.empty()) {
    cout << ready_queue.front().luggageID << " ";
    ready_queue.pop();
  }

  cout << "\n" << setw(23) << setfill(' ') << "" << setw(71) << setfill('-') << "" << endl;
  cout << setw(23) << setfill(' ') << "" << "|";
  for (int i = 0; i<10; i++) {
      string rank = "";
      switch (i) {
            case 0:
                rank = "st";
                break;
            case 1:
                rank = "nd";
                break;
            case 2:
                rank = "rd";
                break;
            default:
                rank = "th";
      }          
      cout <<right << setfill(' ') << setw(3) << (i+1) << rank << " |";    
  }

  cout << "\nReady to be collected: |" << setw(69) << setfill('-') << "" << "|"<< endl;
  cout << setw(23) << setfill(' ') << "" << "|";
  for (int j=0;j<10;j++) {
    cout << right << setw(4) << setfill(' ') << common_space[j].luggageID << right << setw(3) << setfill(' ') << "|";
  }

  cout << "\n" << setw(23) << setfill(' ') << "" << setw(71) << setfill('-') << "" << endl;

  cout << "\n\nUncollected zone: ";
  for (int i = 0;i<20;i++) {
      counter += uncollected_zone[i].inventory.size();
  }
  cout << counter << " luggages.";
  cout << "\n\n" << setfill('=') << setw(94) << "" << endl;
}

int partition(UncollectedRoom uncollected_zone[], int low, int high) {
    int i = low-1, j = low, pivot = uncollected_zone[high].free_space;
    for (;j<=high-1;j++) {
        if (uncollected_zone[j].free_space >= pivot) {
            i++;
            swap(uncollected_zone[i],uncollected_zone[j]);
        }
    }

    swap(uncollected_zone[i+1],uncollected_zone[j]);
    return i+1;
}

void quickSort(UncollectedRoom uncollected_zone[], int low, int high) {
    if (low<high) {
        int pivot = partition(uncollected_zone, low, high);

        quickSort(uncollected_zone, low, pivot-1);
        quickSort(uncollected_zone, pivot+1, high);
    }
}

void appendUncollectedZone(Luggage luggage, UncollectedRoom uncollected_zone[]) {
  int room = 0, number= 0;
  quickSort(uncollected_zone, 0, 20);
  uncollected_zone[0].addNewLuggage(luggage);
}

bool checkCommon(Luggage common_space[]) {
    for (int i = 0; i < 10;i++) {
        if (common_space[i].luggageID != 0) {
            return true;
        }
    }
    return false;
}

void shiftCommonSpaceAndUncollectedZone(Luggage common_space[],  UncollectedRoom uncollected_zone[]) {
  for (int i = 9; i >=0;i--) {
    if (i == 9 && common_space[9].luggageID != 0) {
      appendUncollectedZone(common_space[9], uncollected_zone);
    }
    if (i > 0)
      common_space[i] = common_space[i-1];
    else
      common_space[i] = Luggage();
  }
}

void rotateCommonSpace(Luggage luggage, Luggage common_space[],  UncollectedRoom uncollected_zone[]) {
  shiftCommonSpaceAndUncollectedZone(common_space, uncollected_zone);
  if (common_space[0].luggageID == 0 && common_space[1].luggageID == 0 && checkCommon(common_space)){
      common_space[1] = luggage;
  } else {
      common_space[0] = luggage;
  }

}


int checkInput(int timeoutSeconds) {
    //A file descriptor set, fds is a set of int tht points to opened file or resources
    fd_set fds; 
    //Timeval is a struct that create a structure object for defining the timeout 
    timeval tv;        
    //FD_ZERO empties the fds or reset it 
    FD_ZERO(&fds);            
    //FD_SET import the stdin resources into the first file descriptor
    FD_SET(STDIN_FILENO, &fds);  

    //set the timeout, in this case, which is 10 seconds, for the user to enter luggage id 
    tv.tv_sec = timeoutSeconds;
    //set the fraction part of timeout, in this case which is 0 cuz we only need 10 sec
    tv.tv_usec = 0;

    //select monitors the file descriptor for 10 seconds, or when data is entered by user
    //first arg = highest file descriptor 
    //second arg = file descriptor to monitor 
    //third arg = file descriptor to write
    //fourth arg = file descriptor for handling condition 
    //fifth arg = point to the timeout structure, which is tv
    if (select(STDIN_FILENO + 1, &fds, NULL, NULL, &tv) > 0) {

        int id;
        cin >> id;
        return id;
    } else {
        cout << "\nTimeout reached. Moving on...\n";
        return 0;
    }
}

void collectLuggageAtCommonZone(Luggage common_space[], int id) {
    for (int i = 0; i < 10; ++i) {
        if (common_space[i].luggageID == id) {
            // Shift elements to the right
            for (int j = i; j > 0; --j) {
                common_space[j] = common_space[j - 1];
            }
            // Clear the first slot
            common_space[0] = {};
            return;
        }
    }
    cout << "Luggage with ID " << id << " not found in the common zone.\n";
}

void rotateLuggageCycle(queue<Luggage>& ready_queue, Luggage common_space[], UncollectedRoom uncollected_zone[]) {
  int counter = 0;
  while (!ready_queue.empty() || checkCommon(common_space)) {
    displayLuggagePosition(ready_queue, common_space, uncollected_zone, counter);
    cout << "You have 10 seconds to enter your luggage ID: \n";
    int LID = 0;
    LID = checkInput(2);
    if (LID != 0) {
      collectLuggageAtCommonZone(common_space, LID);
      continue;
    }
    if (!ready_queue.empty()) {
      rotateCommonSpace(ready_queue.front(), common_space, uncollected_zone);
      ready_queue.pop();
    } else {
      shiftCommonSpaceAndUncollectedZone(common_space, uncollected_zone);
    } 
    counter +=10;
  }
  displayLuggagePosition(ready_queue, common_space, uncollected_zone, counter);
}

bool isUncollectedZoneEmpty(UncollectedRoom uncollected_zone[], int total_rooms) {
    for (int i = 0; i < total_rooms; ++i) {
        if (!uncollected_zone[i].inventory.empty())
            return false; // At least one room has luggage
    }
    return true; // All rooms are empty
}

void collectFromUncollectedZone(UncollectedRoom uncollected_zone[], int total_rooms) {
    char option;
    do {
        int luggageID;
        string owner;
        int foundRoom = -1;  // -1 indicates luggage not found
        int foundIndex = -1; // -1 indicates luggage not found

        cout << "Enter luggage ID to collect from the uncollected zone: ";
        cin >> luggageID;

        // Loop through all uncollected rooms
        for (int i = 0; i < total_rooms; ++i) {
            // Check each room's inventory for the luggage
            for (size_t j = 0; j < uncollected_zone[i].inventory.size(); ++j) {
                if (uncollected_zone[i].inventory[j].luggageID == luggageID) {
                    foundRoom = i;
                    foundIndex = j;
                    break; // Exit inner loop once luggage is found
                }
            }
            if (foundRoom != -1) break; // Exit outer loop if luggage is found
        }

        // Handle found luggage
        if (foundRoom != -1) {
            cout << "Luggage " << luggageID << " found in Room " << uncollected_zone[foundRoom].room_id << ".\n";
            cout << "Please enter your name for verification: ";
            cin.ignore();
            getline(cin, owner);

            // Verify if the owner matches
            if (uncollected_zone[foundRoom].inventory[foundIndex].Owner == owner) {
                cout << "Identity verified! Collecting your luggage...\n";
                uncollected_zone[foundRoom].removeLuggage(luggageID); // Remove luggage and update space
                cout << "Luggage " << luggageID << " successfully collected.\n\n";
            } else 
                cout << "Name verification failed. Unable to collect the luggage.\n\n";
            
        }
        else 
            // Luggage not found
            cout << "Luggage ID " << luggageID << " not found in the uncollected zone.\n\n";

        // Ask if the user wants to collect another luggage
        cout << "Do you want to collect another luggage? (Y/N): ";
        cin >> option;

    } while (option == 'Y' || option == 'y'); 

    cout << "Thank you for using the luggage collection service!\n";
}


int main() { 
  //Initialize variable
  int total_luggage = 0, height = 0, width = 0, length = 0, size = 0;
  string color="", owner="";
  Luggage* head = NULL, *tail = NULL;
  queue<Luggage> ready_queue;
  Luggage common_space[10] = {};
  UncollectedRoom uncollected_zone[20] = {};
  char changes = ' ';



  //Get luggage number
  cout << "Please enter the total number of luggage for this flight: ";
  cin >> total_luggage;

  //Store luggage into linked list
  for (int i = 0; i < total_luggage;i++) {
    cout << "Please enter luggage " << (i+1) << "'s Owner: ";
    cin.ignore();
    getline(cin, owner);
    cout << "Luggage color: ";
    cin >> color;
    cout << "Luggage size[Length(cm) Width(cm) Height(cm)]: ";
    cin >> length >> width >> height;
    size = length * width * height;
    storeLuggage(head, tail, i+1, owner, size, color);
  }

  //Display luggage
  displayLuggage(head);
  do {
      updateLuggageInfo(head);
      cout << "Do you want to make new ammendment on the information? [Y/N]:";
      cin >> changes;
  } while (changes == 'Y');

  cout << "\n\nAirplane is arriving, please get ready in" << flush;
  sleep(2);
  cout << " 3.." << flush;
  sleep(1);
  cout << "2.." << flush;
  sleep(1);
  cout << "1..\n\n" << flush;

  retrieveLuggage(head, ready_queue);

  cout << "\nThank you for flying with us! \nNow, please proceed to the \"Luggage reclaim Area\" to collect your luggage. \n\n";
  cout << setfill('=') << setw(94) << "" << endl << right << setw(57) << setfill(' ') << "Luggage Reclaim Area" << endl;

  rotateLuggageCycle(ready_queue,common_space, uncollected_zone); 
  
  // Check if uncollected zones are empty
  if (isUncollectedZoneEmpty(uncollected_zone, 20)) 
    cout << "\nNo luggage available in the uncollected zone.\n";
  
  else 
    // Call the collection function
    collectFromUncollectedZone(uncollected_zone, 20);

    return 0;
}

