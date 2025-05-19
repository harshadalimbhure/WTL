<%@ page import="java.sql.*" %>
<html>
<head>
    <title>Mentee Management</title>
</head>
<body>
<h2>Welcome to Sanjivani College of Engineering, IT Department</h2>

<!-- Single Form with 4 Buttons -->
<form method="post">
    <h3>Mentee Details:</h3>
    Name: <input type="text" name="name"><br>
    Email: <input type="email" name="email"><br>
    Roll No: <input type="number" name="rollno"><br>
    Age: <input type="number" name="age"><br>
    Gender: <input type="text" name="gender"><br><br>

    <!-- 4 Buttons -->
    <input type="submit" name="action" value="Insert">
    <input type="submit" name="action" value="Update">
    <input type="submit" name="action" value="Delete">
    <input type="submit" name="action" value="Display">
</form>

<%
    String action = request.getParameter("action");

    if ("Insert".equals(action)) {
        try {
            Class.forName("com.mysql.jdbc.Driver");
            Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/mentee", "root", "");
            PreparedStatement ps = con.prepareStatement("INSERT INTO mentees (name, email, rollno, age, gender) VALUES (?, ?, ?, ?, ?)");
            ps.setString(1, request.getParameter("name"));
            ps.setString(2, request.getParameter("email"));
            ps.setInt(3, Integer.parseInt(request.getParameter("rollno")));
            ps.setInt(4, Integer.parseInt(request.getParameter("age")));
            ps.setString(5, request.getParameter("gender"));
            ps.executeUpdate();
            out.println("<p style='color:green;'>Record inserted successfully!</p>");
            con.close();
        } catch (Exception e) {
            out.println("<p style='color:red;'>Insert Error: " + e.getMessage() + "</p>");
        }
    }

    if ("Update".equals(action)) {
        try {
            Class.forName("com.mysql.jdbc.Driver");
            Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/mentee", "root", "");
            PreparedStatement ps = con.prepareStatement("UPDATE mentees SET name=?, email=?, age=?, gender=? WHERE rollno=?");
            ps.setString(1, request.getParameter("name"));
            ps.setString(2, request.getParameter("email"));
            ps.setInt(3, Integer.parseInt(request.getParameter("age")));
            ps.setString(4, request.getParameter("gender"));
            ps.setInt(5, Integer.parseInt(request.getParameter("rollno")));
            int rowsUpdated = ps.executeUpdate();
            if (rowsUpdated > 0) {
                out.println("<p style='color:green;'>Record updated successfully!</p>");
            } else {
                out.println("<p style='color:red;'>No record found with given Roll No!</p>");
            }
            con.close();
        } catch (Exception e) {
            out.println("<p style='color:red;'>Update Error: " + e.getMessage() + "</p>");
        }
    }

    if ("Delete".equals(action)) {
        try {
            Class.forName("com.mysql.jdbc.Driver");
            Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/mentee", "root", "");
            PreparedStatement ps = con.prepareStatement("DELETE FROM mentees WHERE rollno=?");
            ps.setInt(1, Integer.parseInt(request.getParameter("rollno")));
            int rowsDeleted = ps.executeUpdate();
            if (rowsDeleted > 0) {
                out.println("<p style='color:green;'>Record deleted successfully!</p>");
            } else {
                out.println("<p style='color:red;'>No record found with given Roll No!</p>");
            }
            con.close();
        } catch (Exception e) {
            out.println("<p style='color:red;'>Delete Error: " + e.getMessage() + "</p>");
        }
    }

    if ("Display".equals(action)) {
%>
    <h3>All Mentees:</h3>
    <table border="2">
        <tr>
            <th>Name</th><th>Email</th><th>Roll No</th><th>Age</th><th>Gender</th>
        </tr>
<%
        try {
            Class.forName("com.mysql.jdbc.Driver");
            Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/mentee", "root", "");
            Statement stmt = con.createStatement();
            ResultSet rs = stmt.executeQuery("SELECT * FROM mentees");
            while (rs.next()) {
%>
        <tr>
            <td><%= rs.getString("name") %></td>
            <td><%= rs.getString("email") %></td>
            <td><%= rs.getInt("rollno") %></td>
            <td><%= rs.getInt("age") %></td>
            <td><%= rs.getString("gender") %></td>
        </tr>
<%
            }
            con.close();
        } catch (Exception e) {
            out.println("<tr><td colspan='5'>Display Error: " + e.getMessage() + "</td></tr>");
        }
%>
    </table>
<%
    }
%>

</body>
</html>
