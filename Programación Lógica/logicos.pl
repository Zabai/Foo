fibo(0, 0).
fibo(1, 1).
fibo(X, Y) :- X>1,
              X1 is X-1,
              fibo(X1, Y1),
              X2 is X-2,
              fibo(X2, Y2),
              Y is Y1+Y2.

expo(_, 0, 1).
expo(B, E, V) :- E > 0, !, E1 is E -1, pow(B,E1,V1), V is B * V1.

minimo([V], V).
minimo([X,Y|R], V):-
    ( X > Y ->
        minimo([Y|R], V)
    ;
        minimo([X|R], V)
    ).

% WIP
%inserta([], V, [V]).
%inserta([C|R1], V, [C|R2]) :- (C >.

invierte(L, R):-  invierteAux(L, [], R).
invierteAux([], V, V).
invierteAux([C|Rl], V, R):-  invierteAux(Rl, [C|V], R).

% WIP
%elimina([], V, []).
%elimina([C|R], V, [C|R]) :- ( C =:= V -> elimina(R, V, R); elimina(R, V, [C|R]) ).


test(V, V).
%test([C|R], [C|R2]).
%padre(frank, ana).