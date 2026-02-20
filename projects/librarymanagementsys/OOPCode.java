import java.util.*;

// Base Class: LibraryItem
abstract class LibraryItem {
    // Data members
    private int itemID;
    private String title;
    private String author;
    private boolean isAvailable;

    // Constructor
    public LibraryItem(int itemID, String title, String author) {
        this.itemID = itemID;
        this.title = title;
        this.author = author;
        this.isAvailable = true;
    }

    // Getters
    public int getItemID() {
        return itemID;
    }

    public String getTitle() {
        return title;
    }

    public String getAuthor() {
        return author;
    }

    // Method to check availability
    public boolean isAvailable() {
        return isAvailable;
    }
    
    public void setAvailable(boolean available) {
        isAvailable = available;
    }

    public abstract String getType();  // This method will return the type (Book, Magazine, Thesis)
    public abstract void displayInfo();  // Display specific details for each item
}

// Subclass: Book
class Book extends LibraryItem {
    private String genre;
    private String ISBN;

    public Book(int itemID, String title, String author, String genre, String ISBN) {
        super(itemID, title, author);
        this.genre = genre;
        this.ISBN = ISBN;
    }
    
    public String getType() {
        return "Book";
    }
    
    public void displayInfo() {
         System.out.println("Book: " + getTitle() + " by " + getAuthor() + ", Genre: " + genre + ", ISBN: " + ISBN + " - " + (isAvailable() ? "Available" : "Not Available"));
    }
}

// Subclass: Magazine
class Magazine extends LibraryItem {
    private int issueNumber;
    private String publishedDate;

    public Magazine(int itemID, String title, String author, int issueNumber, String publishedDate) {
        super(itemID, title, author);
        this.issueNumber = issueNumber;
        this.publishedDate = publishedDate;
    }
    
     public String getType() {
        return "Magazine";
    }
    
   public void displayInfo() {
        System.out.println("Magazine: " + getTitle() + " by " + getAuthor() + ", Issue: " + issueNumber + ", Published: " + publishedDate + " - " + (isAvailable() ? "Available" : "Not Available"));
    }
}

// Subclass: Thesis
class Thesis extends LibraryItem {
    private String researcherName;
    private String supervisor;

    public Thesis(int itemID, String title, String author, String researcherName, String supervisor) {
        super(itemID, title, author);
        this.researcherName = researcherName;
        this.supervisor = supervisor;
    }
    
    public String getType() {
        return "Thesis";
    }

    public void displayInfo() {
        System.out.println("Thesis: " + getTitle() + " by " + getAuthor() + ", Researcher: " + researcherName + ", Supervisor: " + supervisor + " - " + (isAvailable() ? "Available" : "Not Available"));
    }
}

// Library Class
public class Library {
    private static LibraryItem[] libraryItems = new LibraryItem[10];  // Maximum 10 items in the library
    private static int itemCount = 0;  // Track the number of items in the library

    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);

        // Initial items in the library
        addItem(new Book(1, "The Great Gatsby", "F. Scott Fitzgerald", "Fiction", "9780743273565"));
        addItem(new Magazine(2, "National Geographic", "Various", 202, "December 2023"));
        addItem(new Thesis(3, "AI in Healthcare", "John Doe", "Jane Smith", "Dr. Alan Turing"));

        // Main loop
        while (true) {
            System.out.println("\nLibrary System");
            System.out.println("1. Display all items");
            System.out.println("2. Search items by title or type");
            System.out.println("3. Borrow an item");
            System.out.println("4. Return an item");
            System.out.println("5. Add an item");
            System.out.println("6. Remove an item");
            System.out.println("7. Exit");
            System.out.print("Enter your choice: ");
            int choice = scanner.nextInt();
            scanner.nextLine();  
            
            switch (choice) {
                case 1:
                    displayAllItems();
                    break;
                case 2:
                    searchItems(scanner);
                    break;
                case 3:
                    borrowItem(scanner);
                    break;
                case 4:
                    returnItem(scanner);
                    break;
                case 5:
                    addNewItem(scanner);
                    break;
                case 6:
                    removeItem(scanner);
                    break;
                case 7:
                    System.out.println("Thank you for using the library system!");
                    return;
                default:
                    System.out.println("Invalid choice. Please try again.");
            }
        }
    }

    // Display all library items
    public static void displayAllItems() {
        if (itemCount == 0) {
            System.out.println("No items available in the library.");
            return;
        }

        System.out.println("\nLibrary Items:");
        for (int i = 0; i < itemCount; i++) {
            libraryItems[i].displayInfo();
        }
    }

    // Search items by title or type
    public static void searchItems(Scanner scanner) {
        System.out.println("\nSearch for items in the library");
        System.out.println("You can search by either 'title' or 'type'.");

        System.out.print("Enter your choice ('title' or 'type'): ");
        String searchType = scanner.nextLine().toLowerCase();

        if (searchType.equals("title")) {
            System.out.print("Enter the title of the item: ");
            String query = scanner.nextLine();

            boolean found = false;
            for (int i = 0; i < itemCount; i++) {
                if (libraryItems[i].getTitle().equalsIgnoreCase(query)) {
                    libraryItems[i].displayInfo();
                    found = true;
                }
            }
        
            if (!found) 
                System.out.println("No items found with the title: " + query);
                
        } 
        
        else if (searchType.equals("type")) {
            System.out.print("Enter the type of the item (Book, Magazine, Thesis): ");
            String query = scanner.nextLine();

            boolean found = false;
            for (int i = 0; i < itemCount; i++) {
                if (libraryItems[i].getType().equalsIgnoreCase(query)) {
                    libraryItems[i].displayInfo();
                    found = true;
                }
            }
            if (!found) 
                System.out.println("No items found with the type: " + query);
            
        } 
        else 
            System.out.println("Invalid input! Please enter either 'title' or 'type' to search.");
    }

    // Borrow an item
    public static void borrowItem(Scanner scanner) {
        System.out.print("\nEnter item ID to borrow: ");
        int itemID = scanner.nextInt();
        scanner.nextLine(); 

        for (int i = 0; i < itemCount; i++) {
            if (libraryItems[i].getItemID() == itemID) {
                if (libraryItems[i].isAvailable()) {
                    libraryItems[i].setAvailable(false);
                    System.out.println("Item borrowed successfully.");
                    // Calculate due date and fines
                    calculateDueDateAndFines();
                } 
                
                else 
                    System.out.println("Item is not available for borrowing.");
                
                return;
            }
        }
        System.out.println("Item not found.");
    }

    // Return an item
    public static void returnItem(Scanner scanner) {
        System.out.print("\nEnter item ID to return: ");
        int itemID = scanner.nextInt();
        scanner.nextLine();  

        for (int i = 0; i < itemCount; i++) {
            if (libraryItems[i].getItemID() == itemID) {
                if (!libraryItems[i].isAvailable()) {
                    libraryItems[i].setAvailable(true);
                    System.out.println("Item returned successfully.");
                    // Calculate fines for late return
                    calculateFines(7);  // Assume 7 days late 
                } 
                
                else 
                    System.out.println("Item was not borrowed.");
                
                return;
            }
        }
        System.out.println("Item not found.");
    }

    // Add a new item
    public static void addNewItem(Scanner scanner) {
        System.out.print("\nEnter item type (book/magazine/thesis): ");
        String type = scanner.nextLine();
        System.out.print("Enter item ID: ");
        int itemID = scanner.nextInt();
        scanner.nextLine();  
        System.out.print("Enter title: ");
        String title = scanner.nextLine();
        System.out.print("Enter author: ");
        String author = scanner.nextLine();

        if (type.equalsIgnoreCase("book")) {
            System.out.print("Enter genre: ");
            String genre = scanner.nextLine();
            System.out.print("Enter ISBN: ");
            String ISBN = scanner.nextLine();
            addItem(new Book(itemID, title, author, genre, ISBN));
        } 
        
        else if (type.equalsIgnoreCase("magazine")) {
            System.out.print("Enter issue number: ");
            int issueNumber = scanner.nextInt();
            scanner.nextLine(); 
            System.out.print("Enter published date: ");
            String publishedDate = scanner.nextLine();
            addItem(new Magazine(itemID, title, author, issueNumber, publishedDate));
        } 
        
        else if (type.equalsIgnoreCase("thesis")) {
            System.out.print("Enter researcher name: ");
            String researcherName = scanner.nextLine();
            System.out.print("Enter supervisor: ");
            String supervisor = scanner.nextLine();
            addItem(new Thesis(itemID, title, author, researcherName, supervisor));
        }
    }

    // Remove an item
    public static void removeItem(Scanner scanner) {
        System.out.print("\nEnter item ID to remove: ");
        int itemID = scanner.nextInt();
        scanner.nextLine(); 

        for (int i = 0; i < itemCount; i++) {
            if (libraryItems[i].getItemID() == itemID) {
                // Shift items to remove the item
                for (int j = i; j < itemCount - 1; j++) 
                    libraryItems[j] = libraryItems[j + 1];
                
                libraryItems[itemCount - 1] = null;
                itemCount--;
                System.out.println("Item removed successfully.");
                return;
            }
        }
        System.out.println("Item not found.");
    }

    // Add an item to the library
    public static void addItem(LibraryItem item) {
        if (itemCount < libraryItems.length)
            libraryItems[itemCount++] = item;
        
        else 
            System.out.println("Library is full. Cannot add more items.");
        
    }

    // Calculate fines for late return
    public static void calculateFines(int lateDays) {
        double finePerDay = 0.5;  
        double totalFine = lateDays * finePerDay;
        System.out.println("Late return! The fine is: RM" + totalFine);
    }

    // Calculate due date for borrowed items
    public static void calculateDueDateAndFines() {
        System.out.println("Please return the item within 7 days.");
    }
}